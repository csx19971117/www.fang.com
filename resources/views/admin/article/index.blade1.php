@extends('admin.public.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 文章管理
        <span class="c-gray en">&gt;</span> 文章列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <form>
            <div class="text-c"> 日期范围：
                <input value="{{ request()->get('st') }}" type="text" onfocus="WdatePicker({})" name="st" class="input-text Wdate" style="width:120px;">
                -
                <input value="{{ request()->get('et') }}" type="text" onfocus="WdatePicker({})" name="et" class="input-text Wdate" style="width:120px;">
                <input value="{{ request()->get('kw') }}" type="text" class="input-text" style="width:250px" placeholder="输入搜索的账号" name="kw">
                <button type="submit" class="btn btn-success radius" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索一下
                </button>
            </div>
        </form>

        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
                <a href="{{ route('admin.article.create') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加文章
                </a>
            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th>标题</th>
                    <th width="80">分类</th>
                    <th width="120">更新时间</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                {{-- 循环输出内空 --}}
                @foreach($data as $item)
                    <tr class="text-c">
                        <td>{{ $item->id }}</td>
                        <td class="text-l">{{ $item->title }}</td>
                        {{-- 模型关系 --}}
                        <td>{{ $item->cate->cname }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td class="f-14 td-manage">
                            {!! $item->editBtn('admin.article.edit') !!}
                            {!! $item->delBtn('admin.article.destroy') !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <!-- 引入datatables类库文件 -->
    <script src="{{ AdminWeb() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script>
      // 选择对应的类选择器
      // 实例化
      $('.table-sort').dataTable({
        // 页码修改
        lengthMenu: [10, 20, 30, 50, 100],
        // 指定不排序
        columnDefs: [
          // 索引下标为4的不进行排序
          {targets: [4], orderable: false}
        ],
        // 初始化排序
        order: [[0, 'desc']]
      });
    </script>

<!-- <script>
// 选择对应的类选择器
// 实例化
$('.tavle-sort').dataTable({
    // 页码修改
    lengthMenu:[10,20,30,40,50],
    // 指定不排序
    columnDefs:[
        // 索引下标为4的不进行排序
        {targets:[4],orderable:false}
    ],
    // 初始化排序
    order:[[0,'desc']]
});
</script> -->

@endsection

