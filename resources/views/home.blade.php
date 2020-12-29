@extends('layouts.app')

@section('content')
    <style>

        .chat-container{
            display: flex;
            flex-direction: column;
        }
        .chat{
            border: 1px solid gray;
            border-radius: 3px;
            width: 50%;
            padding: 0.5em;
        }
        .chat-left{
            background-color: white;
            align-self: flex-start;
        }
        .chat-right{
            background-color: rgb(255, 166, 0);
            align-self: flex-end;
        }

        .message-input-container{
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;
            border: 1px solid gray;
            padding: 1em;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="chat-container">
                        <div class="card-body">
                            @if(count($chats) === 0 )
                                <p>there is not chat.</p>
                            @endif
                            @foreach ($chats as $chat)

                                @if ($chat->sender_id == auth()->user()->id)

                                       <p class="chat chat-right">{{$chat->sender_name .' : '. $chat->message}}  </p>
                                @else

                                        <p class="chat chat-left">{{$chat->sender_name .' : '. $chat->message}}  </p>

                                @endif

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="message-input-container">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label >Message</label>
                <input type="text" class="form-control" name="message">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">SEND MESSAGE</button>
            </div>
        </form>
    </div>
@endsection


@section('scripts')

    <script>
        const messaging = firebase.messaging();
        messaging.getToken({vapidKey: "BCibBcXpv-v_U1Uapo1MuD078m4cZ-O_UAkXf77lMBEdFp5WK6uVJjQAxlKvUacrv0E9DGgA6GXzASg9h8KJ1p8"});




        function sendTokenToServer(token){

            const user_id = '{{Auth::user()->id}}';

            console.log('token retrieved : ',token);
            axios.post('/api/save-token', {
                token , user_id
            })
            .then(response =>  {
                console.log(response);
            });
        }


        function retrieveToken(){
            messaging.getToken().then((currentToken) => {
            if (currentToken) {
                sendTokenToServer(currentToken);
                // updateUIForPushEnabled(currentToken);
            } else {
            alert('you sould allow notification ');
            }
            }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
            // showToken('Error retrieving registration token. ', err);
            // setTokenSentToServer(false);
            });
        }
        retrieveToken();



        messaging.onTokenRefresh(()=>{
            retrieveToken();
        });

        // add onMessaging listener
        messaging.onMessage((payload)=>{

            console.log('Message Recive');
            console.log(payload);
            location.reload();
        });

    </script>

@endsection
