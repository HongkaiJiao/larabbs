<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


	public function store(ReplyRequest $request,Reply $reply)
	{
	    // XSS 过滤
        $reply->content = clean($request->input('content'));
        // 友好提示
        if (empty($reply->content)) {
            return redirect()->back()->with('danger','回复内容错误!');
        }
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->input('topic_id');
        $reply->save();
		//return redirect()->route('replies.show', $reply->id)->with('message', 'Created successfully.');
        return redirect()->to($reply->topic->link())->with('success','回复成功!');
	}


	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->to($reply->topic->link())->with('success', '删除回复成功!');
	}
}