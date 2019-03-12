@extends('master')

    @section('content')
    
      <table class="striped">
        <thead>
          <tr>
            <th>Tâches</th>
                          
                @isAdmin
            <th>Attribuée à</th>
                @endisAdmin 
                          
            <th>Modifier</th>
            
            <th>Supprimer</th>
          </tr>
        </thead>
            
        <tbody>
                      
            @foreach($tasks as $task)
          <tr>
            <td><a href="{{ route('updatestatus',$task->id) }}">

                @if(!$task->status)
                    {{$task->content }}
                @else
                    <strike class="grey-text">{{$task->content }}</strike>
                @endif

                </a>
            </td>
                            
              @isAdmin
                <td>{{ $task->user->name }}</td>
              @endisAdmin 
                        
                <td><a title="modifier" href="{{ route('edit',$task->id) }}"><i class="small material-icons">edit</i></a></td>
                        
                <td><a title="Supprimer" onclick="return confirm('Delete?');" href="{{ route('delete',$task->id) }}"><i class="small material-icons">delete_forever</i></a></td>
          </tr>
            @endforeach
        </tbody>
      </table>


                  {{ $tasks->links('vendor.pagination.materialize')}}


<!--               <ul class="pagination">
                        <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                        <li class="active"><a href="#!">1</a></li>
                        <li class="waves-effect"><a href="#!">2</a></li>
                        <li class="waves-effect"><a href="#!">3</a></li>
                        <li class="waves-effect"><a href="#!">4</a></li>
                        <li class="waves-effect"><a href="#!">5</a></li>
                        <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                 </ul>      -->
                 
      <form method="POST" action="{{ route('store') }}" class="col s12">
                        
        <div class="row">
          <div class="input-field col s12">
            <input name="task" id="taches" type="text" class="validate">
            <label for="taches">Nouvelle Tâche</label>
          </div>
        </div>

                        
                @include('partials.coworkers')
                
      <button type="submit" class="waves-effect waves-light btn">Ajouter</button>  
                @csrf
        
        </form> 

          @isWorker
                   
      <form method="POST" action="{{ route('sendinvitation') }}" class="col s12">
                 
        <div class="input-field">
          <select name="admin">
            <option value="" disabled selected>Envoyer invitation à...</option>
              
          @foreach ($coworkers as $coworker)
            <option value="{{ $coworker->id }}">{{ $coworker->name }}</option>
          @endforeach
          
          </select>
          <label>Envoyer invitation</label>
        </div>
          <button type="submit" class="waves-effect waves-light btn">Envoyer</button>  
          @csrf
      </form>
                
          @endisWorker
               
          @isAdmin
            <ul class="collection with-header">
                <li class="collection-header"><h4>Listes des collaborateurs</h4></li>
                @foreach($coworkers as $coworker)
                        
                  <li class="collection-item">
                    <div>{{ $coworker->worker->name }}<a href="{{ route('deleteworker',$coworker->id) }}" class="secondary-content">Supprimer</a></div>        
                  </li>
                 @endforeach 
              </ul>
            @endisAdmin
    
    @endsection
 