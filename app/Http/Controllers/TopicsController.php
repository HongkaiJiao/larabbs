<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        // 对除了 index() 和 show() 以外的方法使用 auth 中间件进行认证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,Topic $topic)
	{
	    // 此处 $request->order 是获取 URI http://larabbs.test/topics?order=recent 中的 order 参数
		$topics = $topic->withOrder($request->order)->paginate(30);
		return view('topics.index', compact('topics'));
	}

    public function show(Request $request,Topic $topic)
    {
        // URL 矫正
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(),301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    // 读取所有分类并传参至模板页
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
	    // fill 方法可以将传参的键值数组填充到模型的属性中
		$topic->fill($request->all());
		$topic->user_id = Auth::id(); // 获取当前登录用户的id
        $topic->save();
		return redirect()->to($topic->link())->with('success', '成功创建主题！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '成功删除！');
	}

	// Simditor 编辑框上传图片操作
	public function uploadImage(Request $request,ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认失败
        $data = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file,'topics',Auth::id(),1024);
            if ($result) {
                $data['success'] = true;
                $data['msg'] = '上传成功';
                $data['file_path'] = $result['path'];
            }
        }
        return $data;
    }
}