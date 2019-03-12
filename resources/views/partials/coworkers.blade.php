@isAdmin
    <div class="input-field col s12">
        <select name="assignto">
            <option value="" disabled selected>Attribuer à...</option>
            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
            @foreach($coworkers as $coworker)
                @if(isset($task) && $coworker->worker->id == $task->user->id)
                    <option selected value="{{ $coworker->worker->id }}">{{ $coworker->worker->name }}</option>
                 @else
                    <option value="{{ $coworker->worker->id }}">{{ $coworker->worker->name }}</option>
                @endif
            @endforeach
        </select>
    <label></label>
    </div>
@endisAdmin