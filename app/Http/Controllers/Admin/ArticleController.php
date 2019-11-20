<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\ArticleAddRequest;

class ArticleController extends BaseController {
    // 文章列表
    public function index(Request $request) {
        // 首先判断是不是ajax请求
        if($request->ajax()){
        //  获取总记录数
        $count=Article::count();
        // dd($count);101
        // 分页和起始位置
        $offset=$request->get('start',0);
        // dd($offset);0
        // 获取的记录条数
        $limit=$request->get('length',$this->pagesize);
        // dd($limit);10

            // 排序
            $order=$request->get('order')[0];
            // dd($order); 0,desc 数组
            // 排字字段数组
            $columns=$request->get('columns')[$order['column']];
            // dd($columns);data id
            // 排序的规则
            $orderType=$order['dir'];
            // 排序的字段
            $filed=$columns['data'];
            // 搜索
            $kw=$request->get('kw');
            $builer=Article::when($kw,function($query) use ($kw){
                $query->where('title','like',"%{$kw}%");
            });
            // 获取总条数
            $count=$builer->count();


        // 服务器端的分页
        $data=$builer->with('cate')->orderBy($filed,$orderType)->offset($offset)->limit($limit)->get();
        // dd($data);获取到的数据
        // 返回指定格式的json数据
        return [
            // 客户端调用服务器端的表示
            'draw'=>$request->get('draw'),
            // 获取记录总条数
            'recordsTotal'=>$count,
            // 数据过滤后的总数量
            'recordsFiltered'=>$count,
            // 数据
            'data'=>$data
        ];
        }

        $data=Article::all();
        return view('admin.article.index',compact('data'));
    }

    // 添加文章显示
    public function create() {
        // 读取分类信息
        $cateData = Cate::all()->toArray();
        $cateData = treeLevel($cateData);

        return view('admin.article.create', compact('cateData'));
    }

    // 文件上传
    public function upfile(Request $request) {
        // 获取上传表单文件域名称对应的对象
        $file = $request->file('file');

        // 上传
        // 参1：在节点名称指定的目录下面创建一个新的以此名称的目录，可以不写为空，不创建
        // 参2： 在config中filesystems.php文件中配置的节点名称
        // 返回上传成功的相对路径
        $uri = $file->store('', 'article');
        return ['status' => 0, 'url' => '/uploads/articles/' . $uri];
    }

    // 添加处理
    public function store(ArticleAddRequest $request) {
        $data = $request->except(['_token','file']);
        // 入库
        Article::create($data);
        return redirect(route('admin.article.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article) {
        $cateData = Cate::all()->toArray();
        $cateData = treeLevel($cateData);
        return view('admin.article.edit', compact('cateData', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article) {
        
    }
}
