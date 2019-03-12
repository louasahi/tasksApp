@extends('master')

    @section('content')


                <form method="POST" action="{{ route('update',['id'=>$task->id]) }}" class="col s12">
                        
                        <div class="row">
                          <div class="input-field col s12">
                            <input value="{{$task->content }}" name="task" id="taches1" type="text" class="validate">
                            <label for="taches1">Modification</label>
                          </div>
                        </div>
                   
                    @include('partials.coworkers')

                        <button type="submit" class="waves-effect waves-light btn">Modifier</button>
                    @csrf  
                
                </form> 
    
    @endsection
 