@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            @if ($topic->id)
              编辑话题
            @else
              新建话题
            @endif
          </h2>

          <hr>

          @if ($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
            @else
              <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
          @endif

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          @include('shared._error')

          <div class="mb-3">
            <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title) }}"
              placeholder="请填写标题" required />
          </div>

          <div class="mb-3">
            <select class="form-control" name="category_id" required>
              <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
                @foreach ($categories as $value)
                  <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>
                    {{ $value->name }}
                  </option>
                @endforeach
            </select>
          </div>

          <div class="mb-3" id="editor—wrapper">
            <input name="content" type="hidden" class="form-control" id="editor" required >
            <div id="toolbar-container"><!-- 工具栏 --></div>
            <div id="editor-container"><!-- 编辑器 --></div>
          </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('styles')
    <link href="{{ asset('wangeditor/style.css') }}" rel="stylesheet">
    <style>
  #editor—wrapper {
    border: 1px solid #ccc;
    z-index: 100; /* 按需定义 */
  }
  #toolbar-container { border-bottom: 1px solid #ccc; }
  #editor-container { height: 500px; }
</style>
@endsection

@section('scripts')

<script src="{{ asset('wangeditor/index.js') }}"></script>
<script type="text/javascript">

const { createEditor, createToolbar } = window.wangEditor

const editorConfig = {
    placeholder: '请填入内容',
    onChange(editor) {
      const html = editor.getHtml()
      const text = editor.getText()
      // console.log('editor html', html)
      // console.log('editor text', text)
      // 也可以同步到 <textarea>

      //空|空格|换行
      if(text.match(/^\s*$/)){
          document.getElementById('editor').value=''
        } else {
          document.getElementById('editor').value=html
        }
    },
     MENU_CONF: {}
}
editorConfig.MENU_CONF['uploadImage'] = {
    server: "{{ route('topics.upload_image') }}",
    fieldName: 'topic_upload_image',
    allowedFileTypes: ['image/*'],
    meta: {
      _token: '{{ csrf_token() }}',
    },
    maxNumberOfFiles: 2,
    onSuccess(file, res) {
        console.log(`${file.name} 上传成功`, res)
    },
    // 上传错误，或者触发 timeout 超时
    onError(file, err, res) {
        console.log(`${file.name} 上传出错`, err, res)
    },
    // 小于该值就插入 base64 格式（而不上传），默认为 0
    base64LimitSize: 1 * 1024 // 1kb
}

const localhtml = escape2Html('{{ old("content", $topic->content) }}')

const editor = createEditor({
    selector: '#editor-container',
    html: localhtml,
    config: editorConfig,
    mode: 'simple', // 'defalut' or 'simple'
})

const toolbarConfig = {}

const toolbar = createToolbar({
    editor,
    selector: '#toolbar-container',
    config: toolbarConfig,
    mode: 'simple', // ’default‘or 'simple'
})



//转意符换成普通字符
function escape2Html(str) {
  var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'};
  return str.replace(/&(lt|gt|nbsp|amp|quot);/ig, function(all,t){
    return arrEntities[t];
  });
}
</script>
@endsection
