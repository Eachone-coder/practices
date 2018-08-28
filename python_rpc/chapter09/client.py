# -*- coding: utf-8 -*- 
# @Author: zjx
# @Date  : 2018/8/21

import json
import time
import struct
import socket


def rpc(sock, in_, params):
    # 请求消息体
    request = json.dumps({"in": in_, "params": params})
    # 请求长度前缀
    length_prefix = struct.pack("I", len(request))
    sock.sendall(length_prefix)
    sock.sendall(request)
    # 响应长度前缀
    length_prefix = sock.recv(4)
    length, = struct.unpack("I", length_prefix)
    body = sock.recv(length)
    response = json.loads(body)
    return response["out"], response["result"]

if __name__ == '__main__':
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect(("localhost",8080))
    for i in range(10):
        out, result = rpc(s, "ping", "ireader %d" % i)
        print out ,result
        time.sleep(1)
    s.close()