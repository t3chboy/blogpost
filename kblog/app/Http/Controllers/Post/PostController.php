<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Exception;
use App\Models\PostModel;

class PostController extends Controller
{
	public $postModelObj;

	public function __construct(PostModel $postModel){
		
		$this->postModelObj = new $postModel;
	}
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		$postData = $this->postModelObj->where('status',1)->get();
        return view('post.view_blog_post',compact('postData' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	
		$postData = null ;
		$formaction = '/store';
		return view('post.new_blog_post_form', compact('postData','formaction'));	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		$userid = Auth::user()->id;	
        try{
			$postData = array(
				'title' => $request->input('title'),
				'content' => $request->input('content'),
				'created_by' => 1,
				'updated_by' => 1			
			);
			$response = $this->postModelObj->create( $postData );
			if( $response && $response->wasRecentlyCreated == true ){
				//$data = $this->postModelObj->all();
				return redirect('/view/'.$userid);	
			}			
		
		}catch(Exception $e){
			dd( $e );
		}	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {	
        $postData = $this->postModelObj->where(['status' => 1 ,'created_by' => 1])->get();
		$isallowedactions = true;
        return view('post.view_blog_post',compact('postData','isallowedactions'));
    }
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showall()
    {	
	
        $postData = $this->postModelObj->where(['status' => 1])->get();
		$isallowedactions = false;
        return view('post.view_blog_post',compact('postData','isallowedactions' ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {	
        $postData = $this->postModelObj->find( $id );
		$formaction = '/update/'.$id;
		return view('post.new_blog_post_form', compact('postData','formaction'));	
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {	
		$userid = Auth::user()->id;	
		$response = 0;
		try{
			$postData = array(
				'title' => $request->input('title'),
				'content' => $request->input('content'),
				'updated_by' => 1			
			);
			$response = $this->postModelObj->where('id', $id)->update( $postData );
			if( $response ){
				//$data = $this->postModelObj->all();
				return redirect('/view/'.$userid);	
			}			
		
		}catch(Exception $e){
			dd( $e );
		}	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = 0;
		try{
			$postData = array(
				'status' => 0,
				'updated_by' => 1			
			);
			$response = $this->postModelObj->where('id', $id)->update( $postData );
			if( $response ){
				return redirect('/view/post');	
			}			
		
		}catch(Exception $e){
			dd( $e );
		}	
    }
}
