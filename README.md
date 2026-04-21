# server-monitor

Simple TCP server monitoring utility.

## Usage

Run one or more server checks with `host:port` targets:

```bash
python server_monitor.py --target 127.0.0.1:80 --target 1.1.1.1:53
```

Optional timeout:

```bash
python server_monitor.py --target 127.0.0.1:80 --timeout 1.5
```

The command prints JSON status entries for each target and exits with:

- `0` when all targets are reachable
- `1` when one or more targets are unreachable
