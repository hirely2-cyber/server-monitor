#!/usr/bin/env python3
import argparse
import json
import socket
import time
from dataclasses import asdict, dataclass
from datetime import datetime, timezone
from typing import Iterable, List, Tuple


@dataclass
class ServerStatus:
    target: str
    reachable: bool
    response_time_ms: float | None
    checked_at: str
    error: str | None = None


def parse_target(value: str) -> Tuple[str, int]:
    host, sep, port = value.rpartition(":")
    if not sep or not host or not port.isdigit():
        raise ValueError(f"Invalid target '{value}'. Expected host:port.")
    return host, int(port)


def check_tcp_server(target: str, timeout: float = 3.0) -> ServerStatus:
    checked_at = datetime.now(timezone.utc).isoformat()
    host, port = parse_target(target)
    started = time.perf_counter()
    try:
        with socket.create_connection((host, port), timeout=timeout):
            duration = (time.perf_counter() - started) * 1000
            return ServerStatus(
                target=target,
                reachable=True,
                response_time_ms=round(duration, 2),
                checked_at=checked_at,
            )
    except (OSError, ValueError) as exc:
        return ServerStatus(
            target=target,
            reachable=False,
            response_time_ms=None,
            checked_at=checked_at,
            error=str(exc),
        )


def check_targets(targets: Iterable[str], timeout: float = 3.0) -> List[ServerStatus]:
    return [check_tcp_server(target, timeout=timeout) for target in targets]


def main() -> int:
    parser = argparse.ArgumentParser(description="Simple TCP server monitoring.")
    parser.add_argument(
        "--target",
        action="append",
        required=True,
        help="Server target in host:port format. Repeat for multiple targets.",
    )
    parser.add_argument(
        "--timeout",
        type=float,
        default=3.0,
        help="Socket connection timeout in seconds (default: 3.0).",
    )
    args = parser.parse_args()

    statuses = check_targets(args.target, timeout=args.timeout)
    print(json.dumps([asdict(status) for status in statuses], indent=2))
    return 0 if all(status.reachable for status in statuses) else 1


if __name__ == "__main__":
    raise SystemExit(main())
