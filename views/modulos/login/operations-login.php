<!-- IP DEL EQUIPO LOCAL -->
<script>
    window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection; //compatibility for Firefox and chrome
    var pc = new RTCPeerConnection({
            iceServers: []
        }),
        noop = function() {};
    pc.createDataChannel(''); //create a bogus data channel
    pc.createOffer(pc.setLocalDescription.bind(pc), noop); // create offer and set local description
    pc.onicecandidate = function(ice) {
        if (ice && ice.candidate && ice.candidate.candidate) {
            var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
            console.log('my IP: ', myIP);
            pc.onicecandidate = noop;

            /* document.getElementById('my-ip').innerHTML = myIP;    */
            document.getElementById('ipLan').value = myIP;
            $('.ipLan').val(myIP);
            //$("#ipLan").val(myIP);
        }

    };
</script>

<script>
    $(function() {
        $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
            function(json) {
                //document.write("My public IP address is: ", json.ip);
                $('#ipify').val(json.ip);
                $('.ipify').val(json.ip);
            }
        );
    });
</script>

<div class="login-box">

    <div align="center">
        <p>
            <!-- /.login-logo -->
            <img src="views/dist/img/logo_intro.png" alt="logo" width="312" height="124"> </p>
        <p><br />
        </p>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form method="post">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" class="ipLan" id="ipLan" name="ipLan" value="">
                <input type="hidden" class="ipify" id="ipify" name="ipify" value="">

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <?php 
                $login = new UsersController();
                $login -> ctrLogin();
            ?>



        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->