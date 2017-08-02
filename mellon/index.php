<?php

header('Access-Control-Allow-Origin: *');
include_once dirname(__FILE__) . '/../config.php';
include_once dirname(__FILE__) . '/engine/session.php';

$page = new Page();

if ($page->getURI(0) == "authentication") {
    if ($page->getURI(1) == "login") {
        if ($_POST) {
            if ($engine->account->Login($_POST['email'], $_POST['password'])) {
                header("Location: /account/welcome?msid={$_SESSION['mellon_msid']}&msname=msid");
            } else {
                include_once dirname(__FILE__) . '/template/login.php';
            }
        } else {
            /* if ($engine->session->checkLogin()) {
              header("Location: /account/welcome?msid={$_SESSION['mellon_msid']}&msname=msid");
              } else {
              include_once dirname(__FILE__) . '/template/login.php';
              } */
            include_once dirname(__FILE__) . '/template/login.php';
        }
    } elseif ($page->getURI(1) == "password-reset-request") {
        include_once dirname(__FILE__) . '/template/forgot1.php';
    }
} elseif ($page->getURI(0) == "registration") {
    if ($page->getURI(1) == "index") {
        if ($_POST) {
            $term = isset($_POST['termsAccepted']) ? true : false;
            if ($engine->account->Signup($_POST['email'], $_POST['password']['password'], false, $term)) {
                header("Location: /account/welcome?msid={$_SESSION['mellon_msid']}&msname=msid");
            } else {
                include_once dirname(__FILE__) . '/template/login.php';
            }
        } else {
            include_once dirname(__FILE__) . '/template/register.php';
        }
    }
} elseif ($page->getURI(0) == "account") {
    if ($page->getURI(1) == "welcome") {
        header("Location: /page/redirect/forward/aHR0cDovL2xvYmJ5Lmtpbmdkb21zLmNvbS9hcGkvbG9naW4ucGhwP3Rva2VuPTU2MWE2YzQxOTc5YThkOTIwNWEwMjM0MjhjZGFlNjNh?msid={$_SESSION['mellon_msid']}&msname=msid");
    } elseif ($page->getURI(1) == "logout") {
        include_once dirname(__FILE__) . '/template/logout.php';
    }
} elseif ($page->getURI(0) == "page") {
    if ($page->getURI(1) == "redirect") {
        if ($page->getURI(2) == "forward") {
            include_once dirname(__FILE__) . '/template/redirect.php';
        }
    }
} elseif ($page->getURI(0) == "ajax") {
    if ($page->getURI(1) == "form-validate") {
        if ($_POST['_name_'] == "registration") {
            if (!$engine->account->EmailValid($_POST['email'])) {
                if ($_POST['password'] == "") {
                    header("Content-type: text/json", true);
                    echo json_encode([
                        'success' => false,
                        'isValid' => false,
                        'messages' => [
                            'password' => [
                                'isEmpty' => "Please enter your password"
                            ]
                        ]
                    ]);
                } else {
                    header("Content-type: text/json", true);
                    echo json_encode([
                        'success' => false,
                        'isValid' => false,
                        'messages' => [
                            'password' => [
                                'passwordMatchNotMatch' => "Wrong password"
                            ]
                        ]
                    ]);
                }
            } else {
                header("Content-type: text/json", true);
                echo json_encode([
                    'success' => true,
                    'isValid' => true,
                ]);
            }
        } else {
            if ($engine->account->Login($_POST['email'], $_POST['password'])) {
                header("Content-type: text/json", true);
                echo json_encode([
                    'success' => true,
                    'isValid' => true,
                    'messages' => []
                ]);
            } else {
                if ($engine->account->EmailValid($_POST['email'])) {
                    if ($_POST['password'] == "") {
                        header("Content-type: text/json", true);
                        echo json_encode([
                            'success' => true,
                            'isValid' => false,
                            'messages' => [
                                'password' => [
                                    'isEmpty' => "Please enter your password"
                                ]
                            ]
                        ]);
                    } else {
                        header("Content-type: text/json", true);
                        echo json_encode([
                            'success' => true,
                            'isValid' => false,
                            'messages' => [
                                'password' => [
                                    'passwordMatchNotMatch' => "Wrong password"
                                ]
                            ]
                        ]);
                    }
                } else {
                    header("Content-type: text/json", true);
                    echo json_encode([
                        'success' => true,
                        'isValid' => false,
                        'messages' => [
                            'email' => [
                                'emailForLoginNoEmail' => "Unknown emaill address"
                            ]
                        ]
                    ]);
                }
            }
        }
    } elseif ($page->getURI(1) == "session-validate") {
        header("Content-type: text/json", true);
        echo json_encode(['isValid' => true]);
    } else {
        echo json_encode($page->getURI());
    }
} elseif ($page->getURI(0) == "game-world") {
    if ($page->getURI(1) == "join") {
        $engine->server = (object) $engine->database->getServerInfo($page->getURI(3));
        $msid = $engine->database->msid($_SESSION['mellon_email']);
        if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "localhost") {
            $redirect = $engine->server->folder . "/api/login.php?token=" . md5($msid) . "&msid=" . $msid . "&msname=msid";
            include_once dirname(__FILE__) . '/template/join.php';
        } else {
            $redirect = $engine->server->folder . "/api/login.php?token=" . md5($msid) . "&msid=" . $msid . "&msname=msid";
            include_once dirname(__FILE__) . '/template/join.php';
        }
    }
} elseif ($page->getURI(0) == "min") {
    if ($_GET['g'] == "core-styles") {
        header("Content-type: text/css", true);
        echo file_get_contents(__DIR__ . '/css/core-styles.css');
    } elseif ($_GET['g'] == "styles") {
        header("Content-type: text/css", true);
        echo file_get_contents(__DIR__ . '/css/styles.css');
    } elseif ($_GET['g'] == "core-scripts") {
        echo file_get_contents(__DIR__ . '/js/core-scripts.js');
    } elseif ($_GET['g'] == "scripts") {
        echo file_get_contents(__DIR__ . '/js/scripts.js');
    }
} else {
    if ($page->getURI(0) == "fenster-css.css") {
        header("Content-type: text/css", true);
        echo file_get_contents(__DIR__ . '/tk/fenster-css.css');
    } elseif ($page->getURI(0) == "fenster-js.js") {
        echo file_get_contents(__DIR__ . '/tk/fenster-js.js');
    } elseif ($page->getURI(0) == "sdk-js.js") {
        echo file_get_contents(__DIR__ . '/tk/sdk-js.js');
    } else {
        echo "<pre>";
        var_dump($page->getURI());
        echo "</pre>";
    }
}