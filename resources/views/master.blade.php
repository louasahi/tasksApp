
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Gestion collaborative de tâches</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
  
    <div class="container" >
            

             <form action="{{ route('logout') }}" method="POST">
                                        @csrf
  <p><b>Bonjour {{ Auth::user()->name }}</b>&nbsp;&nbsp;<button type="submit" class="waves-effect waves-light btn">Deconnexion</button></p>
              
              </form>
            @isAdmin
            @if ($invitations->count() >0)
            <ul class="collapsible">
                    <li>
                      <div class="collapsible-header">
                        <i class="material-icons">send</i>
                        Invitations
                        <span class="new badge red" data-badge-caption="Message(s)">{{ $invitations->count() }}</span></div>
                      
                        <div class="collapsible-body">
                        @foreach($invitations as $invitation)
                    <p>
                        <span class="blue-text"><b>{{ $invitation->worker->name }}&nbsp;&nbsp;</b></span>
                        <a href="{{ route('acceptinvitation',['id'=>$invitation->id]) }}">Accepter</a>|<a href="{{ route('denyinvitation',['id'=>$invitation->id]) }}">Refuser</a>
                    </p>
                       @endforeach
                      </div>
                    </li>
            </ul> 
            @endif
            @endisAdmin 

            <h1 class="center-align"> LISTE DE TACHES </h1>
                
            @yield('content')
                
    </div>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var options;
    var instances = M.Collapsible.init(elems, options);
  }); 

  document.addEventListener('DOMContentLoaded', function() {
    var elems1 = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems1);
  });
    </script>    

</body>
</html>
