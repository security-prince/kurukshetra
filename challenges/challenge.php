<?php
session_start();

# if not Authenticated redirect to login
if(!isset($_SESSION['userData']['email']))
{
    header('Location: ../login/index.php');
    die();
}

# Without challenge id, redirect to listing page
if(!isset($_GET['id']))
{
    header('Location: index.php');
    die('failing');
}

# Get the integer value of a variable.
# Careful about exponential
$id = intval($_GET['id']);

require __DIR__ . '/../database/db-credentials.php';

# Get all the challenge details from DB
$query = "SELECT * from challenges where id = '" . mysqli_real_escape_string($connection, $id) . "'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hackademic</title>
        <link rel="stylesheet" href="../staticfiles/css/bootstrap.min.css">
        <link rel="stylesheet" href="../staticfiles/css/animate.css">
        <link rel="stylesheet" href="../staticfiles/css/font-awesome.min.css">
        <link rel="stylesheet" href="../staticfiles/css/style.css">
        <link rel="stylesheet" href="../staticfiles/css/jquery-ui.css" />
	    <script src="../staticfiles/js/jquery-2.1.3.js"></script>
	    <script src="../staticfiles/js/jquery-ui.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Josefin+Sans|Bree+Serif|Righteous' rel='stylesheet' type='text/css'>

    <body>
        <nav class="nav" id="nav">
            <div class="container">
                <div class="navbar-header animated bounceInLeft">
                    <p class="nav-bar-name name">Hackademic</p>
                </div>

<!-- Edit the title below -->

                <div class="title-main">
                    <p><?php echo $row['name']; ?></p>
                </div>

<!-- Edit the title below -->

            </div>
        </nav>

        <div class="output animated bounceInUp">
            <div class="output-text">
                <p id="explanation">Submit the code to see the output.</p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="head">
                <p> <i class="fa fa-file-text-o fa-lg"></i> Explanation</p>
            </div>
            <div class="head1" style="padding:0;">
                <p><i class="fa fa-code fa-lg"></i> Code Editor</p>
            </div>


<!-- Edit the text below -->


            <div class="heading animated bounceInLeft">
                <div class="introdution-text">

                    <h3 id="introdution-title">Introduction</h3>

                    <p id="head-text">
                        <?php echo $row['intro']; ?>
                    </p>

                </div>

                <div class="instructions">
                    <p class="instructions-btn">Instructions</p>
                    <div class="instructions-text">
                        <p class="font2">
                            This area shows the instructions to be followed.
                        </p>
                        <div class="instruction-list">
                            <li class="font2">
                                Instruction 1
                            </li>
                            <li class="font2">
                                Instruction 2
                            </li>
                            <li class="font2">
                                Instruction 3
                            </li>
                            <li class="font2">
                                Instruction 4
                            </li>
                        </div>
                    </div>



                        <div class="hint">
                            <p class="hint-header">Stuck <i class="fa fa-question"></i> <span class="get">Get a hint!</span> <span class="hint-arrow"><i class="fa fa-chevron-down"></i></span></p>
                        </div>


                        <div class="hint-text">
                            <p class="font-intro" >
                                Hint intro here.
                            </p>
                            <p class="font blue">
                                Important hint text goes here.
                            </p>
                            <p class="font" style="font-size:1em;">
                                More hint info goes here.
                            </p>
                            <p class="font black">
                                function sanitize($user_input) {
                                    <br>
                                    $x = htmlspecialchars(trim($user_input));
                                    <br>
                                    return $x;
                                    <br>
                                }
                            </p>
                        </div>
                    </div>
                </div>
            </div>

<!-- Edit the text above -->


            <div class="text-area container-fluid"> </div>

            <div class="color-change">
                <div class="buttons">
                        <div class="lesson-links">
                            <p id="light" class="color_link">Light</p>
                            <p id="dark" class="color_link">Dark</p>
                        </div>
                </div>
            </div>

<!--Editor window start-->

            <div>
                <div class="text-box">

<!-- Change the code below -->

                    <div id="editor"> <?php echo htmlspecialchars($row['code']); ?></div>


<!-- End of editor code -->

                </div>
                <div class="col-md-8  submit-button pull-right">
                    <div class="container-fluid">
                        <button class="btn btn-primary submit-btn" onclick="execute()" id="save">  <span class="btn-text">Submit<span></button>
                        <p class="btn btn-primary reset-btn" id="reset"> Reset Code</p>
                        <p class="btn btn-default button lineno pull-right" id="gutter-change">Line number</p>
                    </div>
                </div>
            </div>

<!--Editor window end-->
            <footer class="footer">
                <div class="col-md-12 aside"></div>
            </footer>

        </div>
    </div>



        <!-- Start of ace editor configuration -->
        <script src="../staticfiles/ace/src-min/ace.js" type="text/javascript" charset="utf-8"></script>
        <script src="../staticfiles/ace/src-min/mode-php.js"></script>

        <script>

            var editor = (function() {
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/ambiance");
                editor.getSession().setTabSize(4);
                document.getElementById('editor').style.fontSize='18px';
                editor.getSession().setMode({path:"ace/mode/php", inline:true});
                editor.setHighlightActiveLine(true);
                editor.setShowPrintMargin(true);
                $("#dark").addClass('color_link_active');
                editor.getSession().setUseWrapMode(true);
                editor.resize();
                return editor;
            })();

            var gutter = false;
            var date=editor.getValue();
            $('#gutter-change').click(function (){
                if(gutter) {
                    editor.renderer.setShowGutter(true);
                    gutter=false;
                    $('#gutter-change').removeClass('reset-btn');
                    $(this).addClass('lineno');

                }
                else {
                    editor.renderer.setShowGutter(false);
                    gutter=true;
                    $('#gutter-change').removeClass('lineno');
                    $(this).addClass('reset-btn');
                }
            });

            data = editor.getValue();

            $('#reset').click(function (){
                editor.setValue(data);
            });


            $('#light').click(function (){
                editor.setTheme("ace/theme/chrome");
                $('#dark').removeClass('color_link_active');
                $(this).addClass('color_link_active');
            });
            $('#dark').click(function (){
                editor.setTheme("ace/theme/ambiance");
                $('#light').removeClass('color_link_active');
                $(this).addClass('color_link_active');
            });

            function execute() {
                var http = new XMLHttpRequest();
                var response = '';
                http.open("POST", "test.php", true);
                http.responseType = "text";
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.onreadystatechange = function() {
                    if (http.readyState == 4 && http.status == 200) {
                        response = http.responseText;
                        document.getElementById("explanation").innerText = response;

                    }
                };
                http.send("function="+ editor.getValue() + "&id=" + window.location.search.substr(1).split("=")[1]);
            }

        </script>

        <!-- End of editor configuration-->

        <script type="text/javascript">

            $(".output").draggable();
            $(".output-text").resizable({ handles: 'n, e, s, w, ne, sw, nw' });
        </script>

        <script src="staticfiles/js/bootstrap.min.js"></script>
        <script src="staticfiles/js/wow.min.js"></script>

        <script>
            var hide = true;
            $(document).ready(function(){
                $(".hint").click(function(){
                    if(hide) {
                        $(".hint-text").hide(1000);
                        hide = false;

                    }
                    else {
                        $(".hint-text").show(1000);
                        hide = true;
                        window.scrollBy(0, 500);
                    }
                });

            });
        </script>
    </body>
</html>