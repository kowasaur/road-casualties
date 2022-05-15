<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en-AU">
    <head>
        <title>Register | Road Casualties</title>
        <?php require_once "components/head.html"; ?>
    </head>

    <body>
        <?php require_once "components/header.html"; ?>

        <div id="page-container">
            <div class="max-width">
                <div id="content-container">
                    <div id="breadcrumbs">
                        <h2>You are here:</h2>
                        <ol>
                            <li><a href=".">Home</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Register</h1>

                                <p>Create an account to receive alerts.</p>
                                <p>Already have an account? Login <a href="404.html">here</a></p>

                                <form class="form">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" required>

                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" required>

                                    <label for="phone">Mobile Number</label>
                                    <input type="tel" name="phone" id="phone" 
                                        placeholder="0414 123 456" 
                                        pattern="[0-9]{4}[- ]*[0-9]{3}[- ]*[0-9]{3}"
                                    />
                                    
                                    <button>Register</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <?php require_once "components/feedback.html"; ?>
                </div>
            </div>
        </div>

        <?php require_once "components/footer.html"; ?>
    </body>
</html>
