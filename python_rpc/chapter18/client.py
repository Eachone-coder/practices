# -*- coding: utf-8 -*- 
# @Author: zjx
# @Date  : 2018/8/28

import sys
sys.path.append("gen-py")

from thrift.transport import TSocket, TTransport
from thrift.protocol import TCompactProtocol

from pi.PiService import Client
from pi.ttypes import PiRequest, IllegalArgument

if __name__ == '__main__':
    sock = TSocket.TSocket("127.0.0.1", 8888)
    transport = TTransport.TBufferedTransport(sock)  # 缓冲模式
    protocol = TCompactProtocol.TCompactProtocol(transport)  # 紧凑模式
    client = Client(protocol)

    transport.open()  # 开启连接
    for i in range(10):
        try:
            res = client.calc(PiRequest(n=i))
            print "pi(%d) =" % i, res.value
        except IllegalArgument as ia:  # 捕获异常
            print "pi(%d)" % i, ia.message
    transport.close()  # 关闭连接