# -*- coding: utf-8 -*- 
# @Author: zjx
# @Date  : 2018/8/20

import socket

sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
sock.connect(("localhost",8080))
sock.sendall(b'hello')
print(sock.recv(1024))
sock.close()

