import socket
import threading
import unittest

from server_monitor import check_tcp_server, parse_target


class TestServerMonitor(unittest.TestCase):
    def test_parse_target_valid(self):
        self.assertEqual(parse_target("localhost:8080"), ("localhost", 8080))

    def test_parse_target_invalid(self):
        with self.assertRaises(ValueError):
            parse_target("localhost")

    def test_check_tcp_server_reachable(self):
        listener = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        listener.bind(("127.0.0.1", 0))
        listener.listen(1)
        port = listener.getsockname()[1]

        def accept_once():
            conn, _ = listener.accept()
            conn.close()
            listener.close()

        thread = threading.Thread(target=accept_once, daemon=True)
        thread.start()

        status = check_tcp_server(f"127.0.0.1:{port}", timeout=1)
        thread.join(timeout=1)

        self.assertTrue(status.reachable)
        self.assertIsNotNone(status.response_time_ms)
        self.assertIsNone(status.error)

    def test_check_tcp_server_unreachable(self):
        status = check_tcp_server("127.0.0.1:1", timeout=0.1)
        self.assertFalse(status.reachable)
        self.assertIsNone(status.response_time_ms)
        self.assertIsNotNone(status.error)


if __name__ == "__main__":
    unittest.main()
