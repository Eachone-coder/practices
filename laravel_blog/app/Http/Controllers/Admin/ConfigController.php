<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController{

    public function index(){
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->conf_content==$r[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }

        }
        return view('admin.config.index',compact('data'));
    }

    public function create(){
        return view('admin/config/add');
    }

    public function store(Request $request){
        $input=$request->except('_token');
        $rules=[
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];
        $message=[
            'conf_name.required'=>'配置名称不能为空',
            'conf_title.required'=>'配置标题不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $config=new Config();
        $config->conf_title=$input['conf_title'];
        $config->conf_name=$input['conf_name'];
        $config->field_type=$input['field_type'];
        $config->field_value=$input['field_value'];
        $config->conf_order=$input['conf_order'];
        $config->conf_tips=$input['conf_tips'];
        if($config->save()){
            return back()->with('errors','添加成功！');
        }else{
            return back()->with('errors','添加失败！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($conf_id){
        $field=Config::find($conf_id);
        return view('admin/config/edit',compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $conf_id){
            $input=$request->except('_token','_method');
            $rules=[
                'conf_name'=>'required',
                'conf_title'=>'required',
            ];
            $message=[
                'conf_name.required'=>'链接名称不能为空',
                'conf_title.required'=>'配置标题不能为空',
            ];
            $validator=Validator::make($input,$rules,$message);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            if(Config::where('conf_id',$conf_id)->update($input)){
                return back()->with('errors','修改成功！');
            }else{
                return back()->with('errors','修改失败！');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($conf_id){
        $re=Config::where('conf_id',$conf_id)->delete();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'删除失败'
            ];
        }
        return $data;
    }
    public function changeOrder(){
        $input=Input::all();
        $conf=Config::find($input['conf_id']);
        $conf->conf_order=$input['conf_order'];
        if($conf->update()){
            $data=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'失败'
            ];
        }
        return $data;
    }
    public function changeContent(){
        $input=Input::all();
        foreach($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功！');
    }
    public function putFile(){
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().DS.'config'.DS.'web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
}
