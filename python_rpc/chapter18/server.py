# -*- coding: utf-8 -*- 
# @Author: zjx
# @Date  : 2018/8/28

import sys
sys.path.append('gen-py')  # 增加 py 包查找路径，这样才可以找到 pi 包
import math

from thrift.transport import TSocket, TTransport
from thrift.protocol import TCompactProtocol
from thrift.server import TServer

from pi.ttypes import PiResponse, IllegalArgument
from pi.PiService import Iface, Processor


class PiHandler(Iface):  # Iface 为 RPC 服务接口

    def calc(self, req):
        if req.n <= 0:
            raise IllegalArgument(message="parameter must be positive")
        s = 0.0
        for i in range(req.n):
            s += 1.0/(2*i+1)/(2*i+1)
        return PiResponse(value=math.sqrt(8*s))


if __name__ == '__main__':
    handler = PiHandler()
    processor = Processor(handler)
    transport = TSocket.TServerSocket(host="127.0.0.1", port=8888)
    tfactory = TTransport.TBufferedTransportFactory()  # 缓冲模式
    pfactory = TCompactProtocol.TCompactProtocolFactory()  # 紧凑模式

    # 线程池服务 RPC 请求
    server = TServer.TThreadPoolServer(processor, transport, tfactory, pfactory)
    # 设置线程池数量
    server.setNumThreads(10)
    # 设置线程为 daemon，当进程只剩下 daemon 线程时会立即退出
    server.daemon = True
    # 启动服务
    server.serve()