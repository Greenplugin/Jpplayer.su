@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                    <a href="https://telegram.me/jpllayer_bot?start=this_session_id">logIn</a>

                    <form action="https://telegram.jpplayer.su/telegram-api/lk23jdsfu_LKkj54cxvb&ihl8-SD9j0hsd" method="post">
                        <input type="text" value="text">
                        <button>send</button>
                    </form>
                </div>

                <div class="panel-heading">log</div>
                <div class="panel-body">
                    <table>
                       <pre>
                            <?php
                                foreach ($data as $key => $val){
                                    /*print_r(json_decode($val['value'],false));*/
                                }

                            ?>
                        </pre>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
