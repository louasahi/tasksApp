<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use App\Invitation;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function index()
{    
    if (Auth::user()->is_admin)
    {
      $tasks = Task::where('user_id',Auth::user()->id)->orWhere('admin_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
      $coworkers = Invitation::where('admin_id',Auth::user()->id)->where('accepted',1)->get();
      $invitations = Invitation::where('admin_id',Auth::user()->id)->where('accepted',0)->get();


    } 
    else
    {
      $invitations = [];
      $tasks = Task::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
      $coworkers = User::where('is_admin',1)->get();
    }
      return view('index',compact('tasks','coworkers','invitations'));  
}

    public function edit($id)
    {
      $task = Task::find($id);

      if (Auth::user()->is_admin)
      {
        $coworkers = Invitation::where('admin_id',Auth::user()->id)->where('accepted',1)->get();
      $invitations = Invitation::where('admin_id',Auth::user()->id)->where('accepted',0)->get();

  
      } 
      else
      {
        $invitations = [];
        $coworkers = [];
      }  
     
      return view('edit',['task'=>$task, 'coworkers'=>$coworkers, 'invitations'=>$invitations]);  
    }


    public function update($id, Request $request )
    {
      if($request->input('task')) 
      {
        $task = Task::find($id);
        $task->content = $request->input('task');


        if (Auth::user()->is_admin)
        {
          
          if($request->input('assignto') == Auth::user()->id) 
          
          {
            Auth::user()->tasks()->save($task);
          } 

          elseif($request->input('assignto') != null)
          
          {
            $task->user_id = $request->input('assignto');
            $task->admin_id = Auth::user()->id;
            $task->save();
          } 
        } 
       
        else
        
        {
          if($this->_authorize($task->user_id))
          $task->save();
        }  

        
      }

      return redirect('/'); 
    }


  public function updatestatus($id)
  {
    $task = Task::find($id);
    $task->status = ! $task->status;
    if($this->_authorize($task->user_id)) 
    $task->save();
    return redirect()->back();  
  }



    public function delete($id)
    {
      $task = Task::find($id);
     
      if(!Auth::user()->is_admin)
       {
        if(!$this->_authorize($task->user_id))
       
        {
        return redirect()->back();
        exit();
       }
       
    }

      $task->delete();
      return redirect()->back();  
    }


    public function store(Request $request )
    {
      if($request->input('task')) 
      {
        $task = new Task;
        $task->content = $request->input('task');

        if (Auth::user()->is_admin)
        {
          if($request->input('assignto') == Auth::user()->id) 
          
          {
            Auth::user()->tasks()->save($task);
          } 

          elseif($request->input('assignto') != null)
          
          {
            $task->user_id = $request->input('assignto');
            $task->admin_id = Auth::user()->id;
            $task->save();
          } 

        
        } 
        else
        
        {
          Auth::user()->tasks()->save($task);
        }  

      }

      return redirect()->back(); 
    }


          public function sendinvitation(Request $request)
          {  
          if(( (int) $request->input('admin') > 0 )&& 
          (!Invitation::where('worker_id',Auth::user()->id)->where('admin_id',$request->input('admin'))->exists()))
              {
                  $Invitation = new Invitation;
                  $Invitation->worker_id = Auth::user()->id;
                  $Invitation->admin_id = (int) $request->input('admin');
                  $Invitation->save();
                  
              }
              return redirect()->back(); 
          }


            public function acceptinvitation($id)

            {
              $Invitation = Invitation::find($id);
              $Invitation->accepted = true;
              if($this->_authorize($Invitation->admin_id)) 
              $Invitation->save();
              return redirect()->back(); 
          }


          public function denyinvitation($id)

            {
              $Invitation = Invitation::find($id);
              if($this->_authorize($Invitation->admin_id)) 
              $Invitation->delete();
              return redirect()->back(); 
              
          }


          public function deleteworker($id)

          {
            $Invitation = Invitation::find($id);
            if($this->_authorize($Invitation->admin_id)) 
            $Invitation->delete();
            return redirect()->back(); 
            
        }



protected function _authorize($id)

{
  return Auth::user()->id === $id ? true:false;
  
}

}





