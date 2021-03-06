<?php
/**
 * This file is part of gamify project.
 * Copyright (C) 2014  Paco Orozco <paco_@_pacoorozco.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @category   Pakus
 * @package    Admin
 * @author     Paco Orozco <paco_@_pacoorozco.info>
 * @license    http://www.gnu.org/licenses/gpl-2.0.html (GPL v2)
 * @link       https://github.com/pacoorozco/gamify
 */

require_once realpath(dirname(__FILE__) . '/../resources/lib/Bootstrap.class.inc');
\Pakus\Core\Bootstrap::init(APP_BOOTSTRAP_FULL);

// Page only for members
if (!userIsLoggedIn()) {
    // save referrer to $_SESSION['nav'] for redirect after login
    redirect('login.php', $includePreviousURL = true);
}

// Check if user has privileges
if (!userHasPrivileges($session->get('member.id'), 'administrator')) {
    // User has no privileges
    require_once TEMPLATES_PATH . '/tpl_header.inc';
    printAccessDenied();
    require_once TEMPLATES_PATH . '/tpl_footer.inc';
    exit();
}

require_once TEMPLATES_PATH . '/tpl_header.inc';

$missatges = array();

// Que hem de fer?
$action = getREQUESTVar('a');
switch ($action) {
    case 'actions':
        printActions();
        break;
    case 'giveexperience':
        $data = array();
        $data['id'] = getPOSTVar('item');
        $data['experience'] = getPOSTVar('experience');
        $data['memo'] = getPOSTVar('memo');
        addExperience($data);
        break;
    case 'givebadge':
        $data = array();
        $data['id_member'] = getPOSTVar('item');
        $data['id_badge'] = getPOSTVar('achievement');
        $data['amount'] = getPOSTVar('amount');
        action($data);
        break;
    case 'users':
        printUserManagement();
        break;
    case 'newuser':
        printNewUserForm();
        break;
    case 'createuser':
        $data = array();
        $data['username'] = getPOSTVar('username');
        $data['password'] = getPOSTVar('password');
        $data['repeatpassword'] = getPOSTVar('repeatpassword');
        $data['email'] = getPOSTVar('email');
        $data['role'] = getPOSTVar('role');
        createUser($data);
        break;
    case 'edituser':
        $userId = getREQUESTVar('item');
        printEditUserForm($userId);
        break;
    case 'saveuser':
        $data = array();
        $data['id'] = getPOSTVar('item');
        $data['password'] = getPOSTVar('password');
        $data['repeatpassword'] = getPOSTVar('repeatpassword');
        $data['email'] = getPOSTVar('email');
        $data['role'] = getPOSTVar('role');
        saveUserData($data);
        break;
    case 'deleteuser':
        $userId = getREQUESTVar('item');
        if (deleteUser($userId)) {
            $missatges[] = array('type' => "success", 'msg' => "L'usuari s'ha el&middot;liminat correctament.");
        } else {
            $missatges[] = array('type' => "error", 'msg' => "No s'ha pogut el&middot;liminar l'usuari.");
        }
        printUserManagement($missatges);
        break;
    case 'levels':
        printLevelManagement();
        break;
    case 'newlevel':
        printNewLevelForm();
        break;
    case 'createlevel':
        $data = array();
        $data['name'] = getPOSTVar('name');
        $data['experience_needed'] = getPOSTVar('experience_needed');
        $data['image'] = getPOSTVar('image');
        createLevel($data);
        break;
    case 'editlevel':
        $levelId = getREQUESTVar('item');
        printEditLevelForm($levelId);
        break;
    case 'savelevel':
        $data = array();
        $data['id'] = getPOSTVar('item');
        $data['name'] = getPOSTVar('name');
        $data['experience_needed'] = getPOSTVar('experience_needed');
        $data['image'] = getPOSTVar('image');
        updateLevel($data);
        break;
    case 'deletelevel':
        $levelId = getREQUESTVar('item');
        if (deleteLevel($levelId)) {
            $missatges[] = array('type' => "success", 'msg' => "El n&iacute;vell s'ha el&middot;liminat correctament.");
        } else {
            $missatges[] = array('type' => "error", 'msg' => "No s'ha pogut el&middot;liminar el n&iacute;vell.");
        }
        printLevelManagement($missatges);
        break;
    case 'badges':
        printBadgeManagement();
        break;
    case 'newbadge':
        printNewBadgeForm();
        break;
    case 'createbadge':
        $data = array();
        $data['name'] = getPOSTVar('name');
        $data['image'] = getPOSTVar('image');
        $data['description'] = getPOSTVar('description');
        $data['amount_needed'] = getPOSTVar('amount_needed');

        createBadge($data);
        break;
    case 'editbadge':
        $badgeId = getREQUESTVar('item');
        printEditBadgeForm($badgeId);
        break;
    case 'savebadge':
        $data = array();
        $data['id'] = getPOSTVar('item');
        $data['name'] = getPOSTVar('name');
        $data['image'] = getPOSTVar('image');
        $data['description'] = getPOSTVar('description');
        $data['amount_needed'] = getPOSTVar('amount_needed');

        updateBadge($data);
        break;
    case 'deletebadge':
        $badgeId = getREQUESTVar('item');

        if (deleteBadge($badgeId)) {
            $missatges[] = array('type' => "success", 'msg' => "La insígnia s'ha el&middot;liminat correctament.");
        } else {
            $missatges[] = array('type' => "error", 'msg' => "No s'ha pogut el&middot;liminar la insígnia.");
        }
        printBadgeManagement($missatges);
        break;
    case 'messages':
        printSendMessage();
        break;
    case 'sendmessage':
        $missatges = array();
        $data = array();
        $subject = getPOSTVar('subject');
        $missatge = getPOSTVar('missatge');

        if (sendMessage($subject, $missatge)) {
            $missatges[] = array('type' => "success", 'msg' => "El missatge s'ha enviat correctament.");
        } else {
            $missatges[] = array('type' => "error", 'msg' => "No s'ha pogut enviar el missatge.");
        }
        printSendMessage($missatges);
        break;
    case 'quiz':
        printQuestionManagement();
        break;
    case 'newquiz':
        printNewQuestionForm();
        break;
    case 'createquiz':
        $data = array();
        $data['name'] = getPOSTVar('name');
        $data['image'] = getPOSTVar('image');
        $data['question'] = getPOSTVar('question');
        $data['tip'] = getPOSTVar('tip');
        $data['solution'] = getPOSTVar('solution');
        $data['type'] = getPOSTVar('type');
        $data['status'] = getPOSTVar('status');

        $data['choices'] = getPOSTVar('choices');
        $data['points'] = getPOSTVar('points');
        $data['correct'] = getPOSTVar('correct');

        $data['actions'] = getPOSTVar('actions');
        $data['when'] = getPOSTVar('when');

        createQuestion($data);
        break;
    case 'editquiz':
        $questionId = getREQUESTVar('item');
        printEditQuestionForm($questionId);
        break;
    case 'savequiz':
        $data = array();
        $data['id'] = getPOSTVar('item');
        $data['name'] = getPOSTVar('name');
        $data['image'] = getPOSTVar('image');
        $data['question'] = getPOSTVar('question');
        $data['tip'] = getPOSTVar('tip');
        $data['solution'] = getPOSTVar('solution');
        $data['type'] = getPOSTVar('type');
        $data['status'] = getPOSTVar('status');

        $data['choices'] = getPOSTVar('choices');
        $data['points'] = getPOSTVar('points');
        $data['correct'] = getPOSTVar('correct');

        $data['actions'] = getPOSTVar('actions');
        $data['when'] = getPOSTVar('when');

        saveQuestionData($data);
        break;
    case 'deletequiz':
        $questionId = getREQUESTVar('item');

        if (deleteQuestion($questionId)) {
            $missatges[] = array('type' => "success", 'msg' => "La pregunta s'ha el&middot;liminat correctament.");
        } else {
            $missatges[] = array('type' => "error", 'msg' => "No s'ha pogut el&middot;liminar la pregunta.");
        }
        printQuestionManagement($missatges);
        break;
    case 'previewquiz':
        $questionId = getREQUESTVar('item');
        printPreviewQuestion($questionId);
        break;
    default:
        printAdminDashboard();
}

require_once TEMPLATES_PATH . '/tpl_footer.inc';
exit();

/*** FUNCTIONS ***/
function printAdminHeader($a = 'users', $msg = array())
{
    ?>
            <h1>Administração</h1>
            <p><?= getHTMLMessages($msg); ?></p>

            <ul class="nav nav-tabs">
                <li<?= ( $a == 'actions' ) ? ' class="active"' : ''; ?>>
                    <a href="admin.php?a=actions"><span class="glyphicon glyphicon-dashboard"></span> Ações </a>
                </li>
                <li<?= ( $a == 'users' ) ? ' class="active"' : ''; ?>>
                    <a href="admin.php?a=users"><span class="glyphicon glyphicon-user"></span>  Usuários </a>
                </li>
                <li<?= ( $a == 'levels' ) ? ' class="active"' : ''; ?>>
                    <a href="admin.php?a=levels"><span class="glyphicon glyphicon-list-alt"></span> Níveis</a>
                </li>
                <li<?= ( $a == 'badges' ) ? ' class="active"' : ''; ?>>
                    <a href="admin.php?a=badges"><span class="glyphicon glyphicon-certificate"></span> Badges </a>
                </li>
                <li<?= ( $a == 'quiz' ) ? ' class="active"' : ''; ?>>
                    <a href="admin.php?a=quiz"><span class="glyphicon glyphicon-comment"></span> Perguntas </a>
                </li>
                <li<?= ( $a == 'messages' ) ? ' class="active"' : ''; ?>>
                    <a href="admin.php?a=messages"><span class="glyphicon glyphicon-envelope"></span> Mensagens </a>
                </li>

            </ul>
    <?php
}

function printAdminDashboard()
{
    printQuestionManagement();
}

function printActions ($msg = array())
{
    global $db;

    $userList = $db->getAll(
        "SELECT id, username FROM members WHERE role = 'member' ORDER BY username"
    );

    // Per incrementar la velocitat, guardem tot el codi en una variable i fem nomes un echo.
    $htmlUsersCode = array();
    foreach ($userList as $row) {
        $htmlUsersCode[] = '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
    }

    $badgeList = $db->getAll(
        "SELECT id, name FROM badges WHERE status = 'active' ORDER BY name"
    );

    // Per incrementar la velocitat, guardem tot el codi en una variable i fem nomes un echo.
    $htmlBadgesCode = array();
    foreach ($badgeList as $row) {
        $htmlBadgesCode[] = '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    printAdminHeader('actions');
    require_once TEMPLATES_PATH . '/tpl_adm_actions_form.inc';
}

function printUserManagement ($msg = array())
{
    global $db;

    printAdminHeader('users', $msg);
    ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <p class="text-right">
                    <a href="admin.php?a=newuser" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span> Novo Usuário </a>
                </p>
                <table class="table table-hover" id="users">
                    <thead>
                        <tr>
                            <th>Usuário </th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $userList = $db->getAll(
        "SELECT id, username, role FROM members ORDER BY username"
    );

    // Per incrementar la velocitat, guardem tot el codi en una variable i fem nomes un echo.
    $htmlCode = array();
    foreach ($userList as $row) {
        $htmlCode[] = '<tr>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="admin.php?a=edituser&item=' . $row['id'] . '">' . $row['username'] . '</a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '<td>' . $row['role'] . '</td>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="admin.php?a=edituser&item='. $row['id'] .'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-edit"></span> Editar</a>';
        $htmlCode[] = '<a href="admin.php?a=deleteuser&item='. $row['id'] .'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"></span> El·liminar</a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '</tr>';
    }
    echo implode(PHP_EOL, $htmlCode);
    unset($htmlCode);
    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    echo getHTMLDataTable('#users');
}

function printLevelManagement($msg = array())
{
    global $db;

    printAdminHeader('levels', $msg);
    ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p class="text-right">
                                    <a href="admin.php?a=newlevel" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span> Nou nivell</a>
                                </p>
                <table class="table table-hover" id="levels">
                    <thead>
                    <tr>
                        <th>Nivell</th>
                        <th>Experiència</th>
                        <th>Imatge</th>
                        <th><abbr title="Assignacions"><span class="glyphicon glyphicon-signal"></span></abbr></th>
                        <th>Accions</th>
                    </tr>
                    </thead>
                    <tbody>
    <?php
    $query = "SELECT id, name, experience_needed, image FROM levels ORDER BY experience_needed";
    $result = $db->query($query);

    // Per incrementar la velocitat, guardem tot el codi en una variable i fem nomes un echo.
    $htmlCode = array();
    while ($row = $result->fetch_assoc()) {
        $htmlCode[] = '<tr>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="admin.php?a=editlevel&item=' . $row['id'] . '">' . $row['name'] . '</a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '<td>' . $row['experience_needed'] . '</td>';
        $htmlCode[] = '<td><img src="' . getLevelImageById($row['id'], false) . '" alt="'. $row['name'] .'" width="64"></td>';
        $htmlCode[] = '<td>' . getLevelAssignements($row['id']) . '</td>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="admin.php?a=editlevel&item='. $row['id'] .'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-edit"></span> Editar</a>';
        $htmlCode[] = '<a href="admin.php?a=deletelevel&item='. $row['id'] .'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"></span> El·liminar</a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '</tr>';
    }
    echo implode(PHP_EOL, $htmlCode);
    unset($htmlCode);
    ?>
                    </tbody>
                </table>
                            </div>
                        </div>
    <?php
    echo getHTMLDataTable('#levels');
}

function printBadgeManagement($msg = array())
{
    global $db;

    printAdminHeader('badges', $msg);
    ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p class="text-right">
                                    <a href="admin.php?a=newbadge" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span> Nova insígnia</a>
                                </p>
                <table class="table table-hover" id="badges">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Imatge</th>
                        <th>Quantitat</th>
                        <th><abbr title="Assignacions"><span class="glyphicon glyphicon-signal"></span></abbr></th>
                        <th>Accions</th>
                    </tr>
                    </thead>
                    <tbody>
    <?php
    $query = "SELECT id, name, image, amount_needed, status FROM badges ORDER BY name";
    $result = $db->query($query);

    // Per incrementar la velocitat, guardem tot el codi en una variable i fem nomes un echo.
    $htmlCode = array();
    while ($row = $result->fetch_assoc()) {
        $htmlCode[] = '<tr>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="admin.php?a=editbadge&item=' . $row['id'] . '">' . $row['name'] . '</a>';
        if ('inactive' == $row['status']) {
            $htmlCode[] = '<span class="label label-danger">inactiva</span>';
        }
        $htmlCode[] = '</td>';
        if (empty($row['image'])) {
            $htmlCode[] = '<td><img src="images/default_badge_off.png" alt="'. $row['name'] .'" class="img-thumbnail" width="64"></td>';
        } else {
            $htmlCode[] = '<td><img src="'. $row['image'] .'" alt="'. $row['name'] .'" class="img-thumbnail" width="64"></td>';
        }
        $htmlCode[] = '<td>'. $row['amount_needed'] .'</td>';
        $htmlCode[] = '<td>' . getBadgeAssignements($row['id']) . '</td>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="admin.php?a=editbadge&item='. $row['id'] .'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-edit"></span> Editar</a>';
        $htmlCode[] = '<a href="admin.php?a=deletebadge&item='. $row['id'] .'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"></span> El·liminar</a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '</tr>';
    }
    echo implode(PHP_EOL, $htmlCode);
    unset($htmlCode);
    ?>
                    </tbody>
                </table>
                            </div>
                        </div>
    <?php
    echo getHTMLDataTable('#badges');
}

/*** USERS ***/
function printNewUserForm($data = array(), $msg = array())
{
    global $CONFIG;
    ?>
                        <h1>Novo Usuário</h1>
                        <p><?= getHTMLMessages($msg); ?></p>
                        <form action="admin.php" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Usuário</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Usuário" value="<?= (isset($data['username'])) ? $data['username'] : ''; ?>" required>
                                </div>
                            </div>
    <?php
    if ($CONFIG['authentication']['type'] == 'LOCAL') {
        ?>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Senha</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="repeatpassword" class="col-sm-2 control-label">Verificar Senha</label>
                                <div class="col-sm-10">i
                                    <input type="password" name="repeatpassword" id="repeatpassword" class="form-control" placeholder="Senha" required>
                                </div>
                            </div>
        <?php
    }
    ?>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">E-mail</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@dominio.com" value="<?= (isset($data['email'])) ? $data['email'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">

                                <label for="role" class="col-sm-2 control-label">Tipo</label>
                                <div class="col-sm-10">
                                    <select name="role" id="role" class="form-control">
                                        <option value="member">Jogador</option>
                                        <option value="administrator">Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" id="a" name="a" value="createuser">
                                    <button type="submit" class="btn btn-success">Criar Usuário</button>
                                    <a href="admin.php?a=users" class="btn btn-default" role="button">Cancelar</a>
                                </div>
                            </div>
                        </form>

    <?php
}

function validateUserData($data, &$msg)
{
    global $CONFIG;
    $error = array();

    // Validate supplied data
    if (!isset($data['id'])) {
        if (empty($data['username'])) {
            $error[] = array(
                'type' => "error",
                'msg'  => "Esse nome de usuário já existe."
            );
        }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = array(
            'type' => "error",
            'msg' => "Problema com e-mail."
        );
    }

    if ($CONFIG['authentication']['type'] == 'LOCAL') {
        if ($data['password'] != $data['repeatpassword']) {
            $error[] = array(
                'type' => "error",
                'msg' => "Os e-mails não iguais."
            );
        }
    } else {
        // set default password to NULL
        $data['password'] = '';
    }

    if (($data['role'] != 'member') && ($data['role'] != 'administrator')) {
        $error[] = array(
            'type' => "error",
            'msg' => "Tipo de usuário incorreto."
        );
    }

    if (!empty($error)) {
        // We have found some errors, returning ot origin call
        $msg = $error;

        return false;
    }

    // All data is validated
    return true;
}

function createUser($data = array())
{
    global $db, $CONFIG;

    $missatges = array();

    // Validate supplied data

    validateUserData($data, $missatges);

    if (getUserExists($data['username'])) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Esse nome de usuário já existe.");
    }

    if ($CONFIG['authentication']['type'] == 'LOCAL') {
        if (empty($data['password'])) {
            $missatges[] = array(
                'type' => "error",
                'msg' => "Campo de senha Obrigatório."
            );
        }
    }

    if (!empty($missatges)) {
        printNewUserForm($data, $missatges);

        return false;
    }

    // User data is correct, now we can insert it to DB
    $userId = $db->insert(
        'members',
        array (
            'uuid' => getNewUUID(),
            'username' => $data['username'],
            'password' => md5($data['password']),
            'email' => $data['email'],
            'role' => $data['role']
        )
    );

    if (0 == $userId) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Falha ao criar usuário. Contate o Administrador."
        );
        printNewUserForm($data, $missatges);

        return false;
    }
    $missatges[] = array(
        'type' => "success",
        'msg' => "Usuário <strong>". $data['username'] ."</strong>' criado com sucesso."
    );
    printUserManagement($missatges);

    return true;
}

function printEditUserForm($userId, $msg = array())
{
    global $db, $CONFIG;
    $missatges = array();

    // user_id must be integer
    $userId = intval($userId);

    // Get user data from DB
    $row = $db->getRow(
        sprintf(
            "SELECT * FROM `members` WHERE `id`='%d' LIMIT 1",
            $userId
        )
    );

    if (is_null($row)) {
        // L'usuari que ens han passat no existeix, per tant tornem a mostrar la llista.
        $missatges[] = array(
            'type' => "error",
            'msg' => "Sem informações sobre o usuário."
        );
        printUserManagement($missatges);

        return false;
    }
    ?>
                        <h1>Editar Usuário</h1>
                        <p><?= getHTMLMessages($msg); ?></p>
                        <form action="admin.php" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Usuário</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static"><?= $row['username']; ?></p>
                                </div>
                            </div>
    <?php
    if ($CONFIG['authentication']['type'] == 'LOCAL') {
        ?>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Senha</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="repeatpassword" class="col-sm-2 control-label">Verificar Senha</label>
                                <div class="col-sm-10">
                                    <input type="password" name="repeatpassword" id="repeatpassword" class="form-control" placeholder="Senha">
                                </div>
                            </div>
        <?php
    }
    ?>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">E-mail</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@dominio.com" value="<?= $row['email']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">Tipo de Usuário</label>
                                <div class="col-sm-10">
                                    <select name="role" id="role" class="form-control">
    <?php
    $availableRoles = array('member', 'administrator');
    foreach ($availableRoles as $opt_key) {
        if ($opt_key == $row['role']) {
            echo '<option value="' . $opt_key . '" selected="selected">' . $opt_key . '</option>';
        } else {
            echo '<option value="' . $opt_key . '">' . $opt_key . '</option>';
        }
    }
    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" id="item" name="item" value="<?= $userId; ?>">
                                    <input type="hidden" id="a" name="a" value="saveuser">
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Atualizar dados</button>
                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?a=users" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-retweet"></span> Tornar</a>
                                </div>
                            </div>
                        </form>

    <?php
}

function saveUserData($data = array())
{
    global $db, $CONFIG;
    $missatges = array();

    // Validate supplied data
    $data['id'] = intval($data['id']);

    if (!getUserExists($data['id'])) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "<strong>Atenção</strong>: Esse usuário não existe."
        );
        printUserManagement($missatges);

        return false;
    }

    if (!validateUserData($data, $missatges)) {
        printEditUserForm($data['id'], $missatges);

        return false;
    }

    // User data is correct, now we can insert it to DB
    $dataToSave = array(
        'email' => $data['email'],
        'role' => $data['role'],
    );
    if (!empty($data['password'])) {
        $dataToSave += array(
            'password' => md5($data['password']),
        );
    }

    if (!$db->update(
        'members',
        $dataToSave,
        sprintf("id='%d'", $data['id'])
    )) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Nao foi possível atualizar o usuário."
        );
        printEditUserForm($data, $missatges);

        return false;
    }
    $missatges[] = array(
        'type' => "success",
        'msg' => "Dados do usuário '<strong>". getUserNameById($data['id']) ."</strong>' atualizados."
    );
    printUserManagement($missatges);

    return true;
}

function deleteUser($userId)
{
    global $db;

    // user_id must be an integer
    $userId = intval($userId);

    $db->delete(
        'members',
        sprintf("id='%d' LIMIT 1", $userId)
    );

    return (!getUserExists($userId));
}

/*** LEVELS ***/
function printNewLevelForm($data = array(), $msg = array())
{
    return printLevelForm('new', $data, $msg);
}

function createLevel($data = array())
{
    global $db;
    $missatges = array();

    if (!validateLevelData($data, $missatges)) {
        printNewLevelForm($data, $missatges);

        return false;
    }

    $levelId = $db->insert(
        'levels',
        array (
            'name' => $data['name'],
            'experience_needed' => $data['experience_needed'],
            'image' => $data['image']
        )
    );

    if (0 == $levelId) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Não foi possível criar esse nível."
        );
        printNewLevelForm($data, $missatges);

        return false;
    }

    $missatges[] = array(
        'type' => "success",
        'msg' => "O nível '<strong>". $data['name'] ."</strong>' foi criado com sucesso."
    );
    printLevelManagement($missatges);

    return true;
}

function printLevelForm($form = '', $data = array(), $msg = array())
{
    $hiddenFields = array();
    $htmlHiddenFields = array();

    if ('edit' == $form) {
        $title = 'Editar nivell';
        $hiddenFields['item'] = $data['id'];
        $hiddenFields['a'] = 'savelevel';
    } else {
        $title = 'Nou nivell';
        $hiddenFields['a'] = 'createlevel';
    }

    // Prepare $data before HTML, if a value doesn't exist give a defaults one
    $required = array('name', 'image', 'experience_needed');
    $data = getVarDefaults($data, $required);

    foreach ($hiddenFields as $name => $value) {
        $htmlHiddenFields[] = '<input type="hidden" id="' . $name . '" name="'
            . $name . '" value="' . $value . '">';
    }

    // Call HTML template, where $form and $data will be used
    include TEMPLATES_PATH . '/tpl_adm_level_form.inc';

    return true;
}

function printEditLevelForm($levelId, $msg = array())
{
    global $db;

    // Get user data from DB
    $data = $db->getRow(
        sprintf("SELECT * FROM levels WHERE id='%d' LIMIT 1", intval($levelId))
    );
    if (is_null($data)) {
        // No existeix.
        $missatges = array(
            'type' => "error",
            'msg' => "Não foi possível criar esse nível."
        );
        printLevelManagement($missatges);

        return false;
    }

    return printLevelForm('edit', $data, $msg);
}

function validateLevelData($data, &$msg)
{
    global $db;

    $error = array();

    // Validate supplied data
    $data['id'] = isset($data['id']) ? intval($data['id']) : 0;
    $data['experience_needed'] = intval($data['experience_needed']);

    if (empty($data['name'])) {
        $error[] = array(
            'type' => "error",
            'msg' => "Esse campo é Obrigatório.");
    }

    if (empty($data['experience_needed'])) {
        $error[] = array(
            'type' => "error",
            'msg' => "O campo Experiência é obrigatório.");
    }

    $levelName = $db->getOne(
        sprintf(
            "SELECT name FROM levels "
            . "WHERE (name='%s' OR experience_needed='%d') AND id != '%d'",
            $db->qstr($data['name']),
            $data['experience_needed'],
            $data['id']
        )
    );

    if (!is_null($levelName)) {
        // A level exists with the same name or with de same experience_needed.
        $error[] = array(
            'type' => "error",
            'msg' => "Já existe um nível para essa experiência."
        );
    }

    if (!empty($error)) {
        // We have found some errors, returning ot origin call
        $msg = $error;

        return false;
    }

    // All data is validated
    return true;
}

function updateLevel($data = array())
{
    global $db;

    $missatges = array();
    $data['id'] = intval($data['id']);

    if (!getLevelExists($data['id'])) {
        // A level doesn't exists .
        $missatges[] = array(
            'type' => "error",
            'msg' => "<strong>Atenção</strong>: O nível solicitado não existe."
        );
        printLevelManagement($missatges);

        return false;
    }

    if (!validateLevelData($data, $missatges)) {
        printEditLevelForm($data['id'], $missatges);

        return false;
    }

    if ($db->update(
        'levels',
        array(
            'name' => $data['name'],
            'experience_needed' => $data['experience_needed'],
            'image' => $data['image']
        ),
        sprintf("id = '%d' LIMIT 1", $data['id'])
    )) {
        $missatges[] = array(
            'type' => "success",
            'msg' => "Dados do nível '<strong>" . $data['name'] . "</strong>' atualizado."
        );
        printLevelManagement($missatges);

        return true;
    }

    $missatges[] = array(
        'type' => "error",
        'msg' => "No s'ha pogut actualitzar les dades del nivell."
    );
    printEditLevelForm($data, $missatges);

    return false;
}

function deleteLevel($levelId)
{
    global $db;

    $db->delete(
        'levels',
        sprintf("id = '%d' LIMIT 1", intval($levelId))
    );

    return (!getLevelExists($levelId));
}

/*** BADGES ***/
function printNewBadgeForm($data = array(), $msg = array())
{
    return printBadgeForm('new', $data, $msg);
}

function createBadge($data = array())
{
    global $db;

    $missatges = array();

    if (!validateBadgeData($data, $missatges)) {
        printNewBadgeForm($data, $missatges);

        return false;
    }

    $badgeId = $db->insert(
        'badges',
        array (
            'name' => $data['name'],
            'image' => $data['image'],
            'description' => $data['description'],
            'amount_needed' => $data['amount_needed']
        )
    );

    if (0 == $badgeId) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Não foi possível criar a Badge."
        );
        printNewLevelForm($data, $missatges);

        return false;
    }
    $missatges[] = array(
        'type' => "success",
        'msg' => "A badge '<strong>". $data['name'] ."</strong>' foi criada."
    );
    printBadgeManagement($missatges);

    return true;
}

function printBadgeForm($form = '', $data = array(), $msg = array())
{
    $hiddenFields = array();
    $htmlHiddenFields = array();

    if ('edit' == $form) {
        $title = 'Editar insígnia';
        $hiddenFields['item'] = $data['id'];
        $hiddenFields['a'] = 'savebadge';
    } else {
        $title = 'Nova insígnia';
        $hiddenFields['a'] = 'createbadge';
    }

    // Prepare $data before HTML, if a value doesn't exist give a defaults one
    $required = array('name', 'image', 'description', 'amount_needed');
    $data = getVarDefaults($data, $required);

    foreach ($hiddenFields as $name => $value) {
        $htmlHiddenFields[] = '<input type="hidden" id="' . $name . '" name="'
            . $name . '" value="'. $value . '">';
    }
    // Call HTML template, where $form and $data will be used
    include TEMPLATES_PATH . '/tpl_adm_badge_form.inc';

    return true;
}

function printEditBadgeForm($badgeId, $msg = array())
{
    global $db;

    // Get user data from DB
    $data = $db->getRow(
        sprintf("SELECT * FROM badges WHERE id='%d' LIMIT 1", intval($badgeId))
    );

    if (is_null($data)) {
        $missatges = array(
            'type' => "error",
            'msg' => "Não há informações sobre essa Badge."
        );
        printBadgeManagement($missatges);

        return false;
    }

    return printBadgeForm('edit', $data, $msg);
}

function validateBadgeData($data, &$msg)
{
    global $db;
    $error = array();

    // Validate supplied data
    $data['id'] = isset($data['id']) ? intval($data['id']) : 0;
    $data['amount_needed'] = intval($data['amount_needed']);

    if (empty($data['name'])) {
        $error[] = array(
            'type' => "error",
            'msg' => "O nome da Badge é obrigatório."
        );
    }

    if (empty($data['amount_needed'])) {
        $error[] = array(
            'type' => "error",
            'msg' => "A quantidade é obrigatória."
        );
    }

    $badgeName = $db->getOne(
        sprintf(
            "SELECT name FROM badges "
            . "WHERE name='%s' AND id!='%d' LIMIT 1",
            $data['name'],
            $data['id']
        )
    );

    if (!is_null($badgeName)) {
        // A badge exists with the same name or with de same experience_needed.
        $error[] = array(
            'type' => "error",
            'msg' => "Já existe uma Badge com esse nome."
        );
    }

    if (!empty($error)) {
        // We have found some errors, returning ot origin call
        $msg = $error;

        return false;
    }

    // All data is validated
    return true;
}

function updateBadge($data = array())
{
    global $db;

    $missatges = array();

    // Validate supplied data
    $data['id'] = intval($data['id']);
    $data['amount_needed'] = intval($data['amount_needed']);

    if (!getBadgeExists($data['id'])) {
        // A badge doesn't exists .
        $missatges[] = array(
            'type' => "error",
            'msg' => "<strong>Atenção</strong>: A badge não existe."
        );
        printBadgeManagement($missatges);

        return false;
    }

    if (!validateBadgeData($data, $missatges)) {
        printEditBadgeForm($data['badge_id'], $missatges);

        return false;
    }

    if ($db->update(
        'badges',
        array(
            'name' => $data['name'],
            'image' => $data['image'],
            'description' => $data['description'],
            'amount_needed' => $data['amount_needed']
        ),
        sprintf("id='%d' LIMIT 1", $data['id'])
    )) {
        $missatges[] = array(
            'type' => "success",
            'msg' => "A Badge '<strong>". $data['name'] ."</strong>' foi atualizada."
        );
        printBadgeManagement($missatges);

        return true;
    }
    $missatges[] = array(
        'type' => "error",
        'msg' => "Não foi possível atualizar os dados da Badge."
    );
    printEditBadgeForm($data, $missatges);

    return false;
}

function deleteBadge($badgeId)
{
    global $db;

    $db->delete(
        'badges',
        sprintf("id = '%d' LIMIT 1", intval($badgeId))
    );

    return (!getBadgeExists($badgeId));
}

function addExperience($data = array())
{
    global $db;
    $missatges = array();

    // validate data
    $userId = intval($data['id']);
    $experience = intval($data['experience']);
    $memo = $data['memo'];

    if (!getUserExists($userId) || empty($experience)) {
        // Parametres erronis
        $missatges[] = array(
            'type' => "error",
            'msg' => "Os dados fornecidos estão incorretos."
        );
        printActions($missatges);

        return false;
    }

    $username = getUserNameById($userId);
    if (!doSilentAddExperience($userId, $experience, $memo)) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Não foi possível atualizar os dados do usuário "
            . "'<strong>". $username ."</strong>."
        );
        printActions($missatges);

        return false;
    }

    $missatges[] = array(
        'type' => "success",
        'msg' => "Dados do usuário '<strong>" . $username . "</strong>' atualizados."
    );
    printActions($missatges);

    return true;
}

function action($data = array())
{
    $missatges = array();
    $userId = intval($data['id_member']);
    $badgeId = intval($data['id_badge']);
    $amount = intval($data['amount']);

    // validate data
    if (!getUserExists($userId)
        || !getBadgeExists($badgeId)
        || empty($amount)) {
        // L'usuari o el badge que ens han passat no existeix.
        $missatges[] = array(
            'type' => "error",
            'msg' => "Os dados fornecidos estão incorretos."
        );
        printActions($missatges);

        return false;
    }

    $username = getUserNameById($userId);
    if (!doSilentAction($userId, $badgeId)) {
        $missatges[] = array(
            'type' => "error",
            'msg' => "Não foi possível atualizar os dados do usuário "
            . "'<strong>". $username ."</strong>."
        );
        printActions($missatges);

        return false;
    }

    $missatges[] = array(
        'type' => "success",
        'msg' => "Dados do usuário "
        . "'<strong>" . $username . "</strong>' atualizados."
    );
    printActions($missatges);

    return true;
}

function printSendMessage($msg = array())
{
    global $db;

    printAdminHeader('messages');

    $query = "SELECT email FROM vmembers WHERE role='member'";
    $result = $db->query($query);

    $bccRecipients = array();
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['email'])) {
            $bccRecipients[] = $row['email'];
        }
    }

    ?>
               <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Enviar e-mail para Jogador</h2>
                    <p><?= getHTMLMessages($msg); ?></p>
                    <form action="admin.php" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">Títol</label>
                            <div class="col-sm-10">
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Assunto" required>
                            </div>
                        </div>

                            <div class="form-group">
                                <label for="missatge" class="col-sm-2 control-label">Missatge</label>
                                <div class="col-sm-10">
                                    <textarea name="missatge" id="missatge" class="form-control tinymce" rows="3" placeholder="Mensagem"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bcc" class="col-sm-2 control-label">Destinatário</label>
                                <div class="col-sm-10">
                                    <textarea id="bcc" class="form-control" rows="3" style="display:none;" disabled><?= implode(',', $bccRecipients); ?></textarea>
                                    <a id="bcc_btn" href="#" class="btn btn-default" onClick="$('#bcc_btn').hide(); $('#bcc').show()"><span class="glyphicon glyphicon-eye-open"></span> Mostrar Destinatários</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" id="a" name="a" value="sendmessage">
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span> Enviar mensagem</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
    <?php
}

function printQuestionManagement($msg = array())
{
    global $db;

    printAdminHeader('quiz', $msg);
    ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p class="text-right">
                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?a=newquiz" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span> Nova Pergunta</a>
                                </p>
                <table class="table table-hover" id="questions">
                    <thead>
                    <tr>
                        <th>Perguntas</th>
                        <th>Estado</th>
                        <th><span class="glyphicon glyphicon-tags"></span></th>
                        <th><abbr title="Respostes"><span class="glyphicon glyphicon-signal"></span></abbr></th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
    <?php
    $query = "SELECT id, uuid, name, status FROM questions ORDER BY name";
    $result = $db->query($query);

    // Per incrementar la velocitat, guardem tot el codi en una variable i fem nomes un echo.
    $htmlCode = array();
    while ($row = $result->fetch_assoc()) {
        $htmlCode[] = '<tr>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="'. $_SERVER['PHP_SELF'] .'?a=editquiz&item=' . $row['id'] . '">' . $row['name'] . '</a> <a href="quiz.php?a=answerqz&item=' . $row['uuid'] . '" title="Enllaç p&uacute;blic" target="_blank"><span class="glyphicon glyphicon-link"></span></a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '<td>';

        switch ($row['status']) {
            case 'inactive':
                $htmlCode[] = '<span class="label label-danger">Inativa</span>';
                break;
            case 'draft':
                $htmlCode[] = '<span class="label label-info">Rascunho</span>';
                break;
            case 'hidden':
                $htmlCode[] = '<span class="label label-warning">Oculta</span>';
                break;
            case 'active':
            default:
                $htmlCode[] = '<span class="label label-success">Publicada</span>';
                break;
        }

        $htmlCode[] = '</td>';
        $htmlCode[] = '<td></td>';
        $htmlCode[] = '<td>' . getQuestionResponses($row['uuid']) . '</td>';
        $htmlCode[] = '<td>';
        $htmlCode[] = '<a href="'. $_SERVER['PHP_SELF'] .'?a=editquiz&item='. $row['id'] .'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-edit"></span> Editar</a>';
        $htmlCode[] = '<a href="'. $_SERVER['PHP_SELF'] .'?a=previewquiz&item='. $row['id'] .'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-eye-open"></span> Visualizar</a>';
        $htmlCode[] = '<a href="'. $_SERVER['PHP_SELF'] .'?a=deletequiz&item='. $row['id'] .'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"></span> Deletar</a>';
        $htmlCode[] = '</td>';
        $htmlCode[] = '</tr>';
    }
    echo implode(PHP_EOL, $htmlCode);
    unset($htmlCode);
    ?>
                    </tbody>
                </table>
                            </div>
                        </div>
    <?php
    echo getHTMLDataTable('#questions');
}

function printEditQuestionForm($questionId, $msg = array())
{
    global $db;

    $missatges = array();

    // question_id must be integer
    $questionId = intval($questionId);

    // get question data from DB
    $data = $db->getRow(
        sprintf("SELECT * FROM questions WHERE id='%d' LIMIT 1", $questionId)
    );
    if (is_null($data)) {
        // No existeix.
        $missatges[] = array(
            'type' => "error",
            'msg' => "Não há informações sobre essa pergunta."
        );
        printQuestionManagement($missatges);

        return false;
    }

    // get all question_choices data from DB
    $query = sprintf("SELECT * FROM questions_choices WHERE question_id='%d'", $questionId);
    $result = $db->query($query);

    $data['choices'] = array();
    $data['points'] = array();
    $data['correct'] = array();
    while ($row = $result->fetch_assoc()) {
        $data['choices'][] = $row['choice'];
        $data['points'][] = $row['points'];
        $data['correct'][] = $row['correct'];
    }

    // get all question_actions data from DB
    $query = sprintf("SELECT * FROM questions_badges WHERE question_id='%d'", $questionId);
    $result = $db->query($query);

    $data['actions'] = array();
    $data['when'] = array();
    while ($row = $result->fetch_assoc()) {
        $data['actions'][] = $row['badge_id'];
        $data['when'][] = $row['type'];
    }
    ?>
                        <h1>Editar Pergunta</h1>
                        <p><?= getHTMLMessages($msg); ?></p>
                        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" role="form">

                            <?php printQuestionContentForm($data); ?>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" id="item" name="item" value="<?= $data['id']; ?>">
                                    <input type="hidden" id="a" name="a" value="savequiz">
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Atualizar Dados</button>
                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?a=quiz" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-retweet"></span> Voltar</a>
                                </div>
                            </div>
                        </form>
    <?php
}

function printNewQuestionForm($data = array(), $msg = array())
{
    global $db;
    ?>
                        <h1>Nova Pergunta</h1>
                        <p><?= getHTMLMessages($msg); ?></p>
                        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" role="form">

                            <?php printQuestionContentForm($data); ?>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" id="a" name="a" value="createquiz">
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Criar Pergunta</button>
                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?a=quiz" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-retweet"></span> Voltar</a>
                                </div>
                            </div>
                        </form>

    <?php
}

function notifyPublishedQuestion($questionId)
{
    global $db;
    
    $status = $db->getOne(
        sprintf(
            "SELECT `status` FROM `questions` "
            . "WHERE `id`='%d' LIMIT 1",
            $questionId
        )
    );    

    if ('active' == $status) {
        //sendPublishedQuestionMessage($questionId, 'members');
        sendPublishedQuestionMessage($questionId, 'admins');
    }
    if ('hidden' == $status) {
        sendPublishedQuestionMessage($questionId, 'admins');
    }
}

function sendPublishedQuestionMessage($questionId, $whom)
{
    global $db;
    
    if ($whom == 'admins') {
        $receiver = $db->getAll(
            "SELECT email FROM vmembers WHERE role = 'administrator' AND disabled = '0'"
        );
    }
    if ($whom == 'members') {
        $receiver = $db->getAll(
            "SELECT email FROM vmembers WHERE role = 'members' AND notifyme = '1'"
        );
    }    
    
    $mailAddresses = array();
    foreach ($receiver as $recv) {
        $mailAddresses[] = $recv['email'];
    }
    
    $questionLink = getQuestionLink($questionId);
    $questionName = getQuestionName($questionId);
    $subject = "Nova Pergunta Adicionada no Red Hat Rally!";
    $missatge = <<<NEWQUESTION_MAIL
<div style="text-align:center;">
<h2>Nova Pergunta Adicionada no Red Hat Rally!</h2>
<p style="padding-bottom: 10px;"><a href="$questionLink">$questionName</a>.</p>
</div>
NEWQUESTION_MAIL;
    
    sendMessage($subject, $missatge, $mailAddresses);
    
}

function createQuestion($data = array())
{
    global $db;
    $missatges = array();

    // Validate supplied data

    // Question data is correct, now we can insert it to DB
    $questionId = $db->insert(
        'questions',
        array(
            'uuid' => getNewUUID(),
            'name' => $data['name'],
            'image' => $data['image'],
            'question' => $data['question'],
            'tip' => $data['tip'],
            'solution' => $data['solution'],
            'type' => $data['type'],
            'status' => $data['status']
        )
    );

    if (0 == $questionId) {
            $missatges[] = array('type' => "error", 'msg' => "Não foi possível criar a pergunta.");
            printNewQuestionForm($data, $missatges);

            return false;
    }

    if ('active' == $data['status'] || 'hidden' == $data['status']) {
        setQuestionPublishTime($questionId);
    }
    
    // put choices into its table
    foreach ($data['choices'] as $key => $value) {
        // validate supplied data
        if (empty($value)) {
            continue;
        }
        $db->insert(
            'questions_choices',
            array(
                'question_id' => $questionId,
                'choice' => $value,
                'correct' => $data['correct'][$key],
                'points' => intval($data['points'][$key])
            )
        );
    }

    // put actions into its table
    foreach ($data['actions'] as $key => $value) {
        // validate supplied data
        $value = intval($value);
        if (empty($value)) {
            continue;
        }
        $db->insert(
            'questions_badges',
            array(
                'question_id' => $questionId,
                'badge_id' => $value,
                'type' => $data['when'][$key]
            )
        );
    }
    
    $missatges[] = array(
        'type' => "success",
        'msg' => "Pergunta criada com Sucesso."
    );
    printQuestionManagement($missatges);

    return true;
}

/**
 * Set 'publish_date' column ONLY if it hasn't been set before
 *
 * @param int $questionId
 */
function setQuestionPublishTime($questionId)
{
    global $db;
    $publishDate = $db->getOne(
        sprintf(
            "SELECT `publish_time` FROM `questions` "
            . "WHERE `id`='%d' AND `publish_time` != 0 LIMIT 1",
            $questionId
        )
    );
    if (is_null($publishDate)) {
        $db->update(
            'questions',
            array(
                'publish_time' => date('Y-m-d H:i:s')
            ),
            sprintf("id='%d' LIMIT 1", $questionId)
        );
        
        notifyPublishedQuestion($questionId);
    }
}

function saveQuestionData($data = array())
{
    global $db;

    $missatges = array();

    // TODO - Validate supplied data
    $data['id'] = intval($data['id']);

    // delete all choices and insert it again
    $db->delete(
        'questions_choices',
        sprintf("question_id='%d'", $data['id'])
    );

    // put choices into its table
    foreach ($data['choices'] as $key => $value) {

        // validate supplied data
        if (empty($value)) {
            continue;
        }

        $db->insert(
            'questions_choices',
            array(
                'question_id' => $data['id'],
                'choice' => $value,
                'correct' => $data['correct'][$key],
                'points' => intval($data['points'][$key])
            )
        );
    }

    // delete all actions and insert it again
    $db->delete(
        'questions_badges',
        sprintf("question_id='%d'", $data['id'])
    );

    // put actions into its table
    foreach ($data['actions'] as $key => $value) {

        // validate supplied data
        $value = intval($value);
        if (empty($value)) {
            continue;
        }

        $db->insert(
            'questions_badges',
            array(
                'question_id' => $data['id'],
                'badge_id' => $value,
                'type' => $data['when'][$key]
            )
        );
    }

    // Question data is correct, now we can insert it to DB
    $result = $db->update(
        'questions',
        array(
            'name' => $data['name'],
            'image' => $data['image'],
            'question' => $data['question'],
            'tip' => $data['tip'],
            'solution' => $data['solution'],
            'type' => $data['type'],
            'status' => $data['status']
        ),
        sprintf("id='%d' LIMIT 1", $data['id'])
    );

    if ('active' == $data['status'] || 'hidden' == $data['status']) {
        setQuestionPublishTime($data['id']);
    }

    if ($result) {
        $missatges[] = array('type' => "success", 'msg' => "Dados atualizados.");
        printQuestionManagement($missatges);
    } else {
        $missatges[] = array('type' => "error", 'msg' => "Não há perguntas com esses dados.");
        printEditQuestionForm($data, $missatges);
    }
}

function deleteQuestion($questionId)
{
    global $db;

    // question_id must be an integer
    $questionId = intval($questionId);

    // delete all choices
    $db->delete(
        'questions_choices',
        sprintf("question_id='%d'", $questionId)
    );

    // delete all actions
    $db->delete(
        'questions_badges',
        sprintf("question_id='%d'", $questionId)
    );

    return $db->delete(
        'questions',
        sprintf("id='%d' LIMIT 1", $questionId)
    );
}

function printQuestionContentForm($data)
{
    global $db;

    // Prepare $data before HTML, if a value doesn't exist give a defaults one
    $required = array('name', 'question', 'image', 'solution', 'tip');
    $data = getVarDefaults($data, $required);
    ?>
                               <div class="form-group">
                                    <label class="col-sm-2 control-label">Nome</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" placeholder="Título da Pergunta" value="<?= $data['name']; ?>" required>
                                    </div>
                               </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Estado</label>
                                    <div class="col-sm-2">
                                        <select name="status" class="form-control">
    <?php
    $availableOptions = array(
        'draft' => 'Rascunho',
        'active' => 'Ativa',
        'hidden' => 'Oculta',
        'inactive' => 'Inativa'
    );
    echo getHTMLSelectOptions($availableOptions, $data['status']);
    ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Pergunta</label>
                                    <div class="col-sm-10">
                                        <textarea name="question" class="form-control tinymce" rows="3" placeholder="Qual a Pergunta?"><?= $data['question']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="col-sm-2 control-label">Imagem</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="image" class="form-control" placeholder="Url da Imagem (opcional)" value="<?= $data['image']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo</label>
                                    <div class="col-sm-2">
                                        <select name="type" class="form-control">
    <?php
    $availableOptions = array(
        'single' => 'Resposta única',
        'multi' => 'Resposta multiple'
    );
    echo getHTMLSelectOptions($availableOptions, $data['type']);
    ?>
                                        </select>
                                    </div>
                                </div>

                                <legend>Respostes possibles</legend>
                                <div class="form-group">
                                    <label class="col-sm-offset-2 col-sm-6">Texto da Pergunta</label>
                                    <label class="col-sm-2">Pontos</label>
                                    <label class="col-sm-1">Correta?</label>
                                </div>

    <?php
    foreach ($data['choices'] as $key => $value) {
        ?>
                                    <div class="clonable">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-6">
                                                <input type="text" name="choices[]" class="form-control" placeholder="Texto da Resposta" value="<?= $value; ?>">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" name="points[]" class="form-control" placeholder="Pontos" value="<?= $data['points'][$key]; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <select name="correct[]" class="form-control">
        <?php
        $availableOptions = array(
            'yes' => 'Si',
            'no' => 'No'
        );
        echo getHTMLSelectOptions($availableOptions, $data['correct'][$key]);
        ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <span class="input-group-btn"><button type="button" class="btn btn-danger btn-remove">-</button></span>
                                            </div>
                                        </div>
                                    </div>
        <?php
    }
    ?>

                                <div class="clonable">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-6">
                                            <input type="text" name="choices[]" class="form-control" placeholder="Texto da resposta">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="points[]" class="form-control" placeholder="Pontos">
                                        </div>
                                        <div class="col-sm-1">
                                            <select name="correct[]" class="form-control">
    <?php
    $availableOptions = array(
        'yes' => 'Si',
        'no' => 'No'
    );
    echo getHTMLSelectOptions($availableOptions, 'no');
    ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <span class="input-group-btn"><button type="button" class="btn btn-default btn-add">+</button></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Explicação da Resposta</label>
                                    <div class="col-sm-10">
                                        <textarea name="solution" class="form-control tinymce" rows="3" placeholder="Solução detalhada (opcional)"><?= $data['solution']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tip" class="col-sm-2 control-label">Texto de ajuda a pesquisa</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tip" class="form-control" placeholder="Texto de ajuda a pesquisa (opcional)" value="<?= $data['tip']; ?>">
                                    </div>
                                </div>

    <?php
    $query = "SELECT id, name FROM badges WHERE status='active'";
    $result = $db->query($query);
    $availableActions = array();
    while ($row = $result->fetch_assoc()) {
        $availableActions[$row['id']] = $row['name'];
    }
    ?>

                                <legend>Ações associadas</legend>

    <?php
    foreach ($data['actions'] as $key => $value) {
        ?>
                                    <div class="clonable">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Adicionar Ação</label>
                                            <div class="col-sm-4">
                                                <select name="actions[]" class="form-control">
                                                    <option value="">Nenhuma Ação </option>
        <?= getHTMLSelectOptions($availableActions, $value); ?>
                                                </select>
                                            </div>
                                            <label class="col-sm-1 control-label">Quando</label>
                                            <div class="col-sm-4">
                                                <select name="when[]" class="form-control">
        <?php
        $availableOptions = array(
            'success' => 'Resposta Correta',
            'fail' => 'Resposta Incorreta',
            'always' => 'Sempre'
        );
        echo getHTMLSelectOptions($availableOptions, $data['when'][$key]);
        ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <span class="input-group-btn"><button type="button" class="btn btn-danger btn-trash">-</button></span>
                                            </div>
                                        </div>
                                    </div>
        <?php
    }
    ?>
                                <div class="clonable">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Adicionar Ação</label>
                                        <div class="col-sm-4">
                                            <select name="actions[]" class="form-control">
                                                <option value="">Nenhuma Ação</option>
    <?= getHTMLSelectOptions($availableActions); ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 control-label">Quando</label>
                                        <div class="col-sm-4">
                                            <select name="when[]" class="form-control">
    <?php
    $availableOptions = array(
        'success' => 'Resposta Correta',
        'fail' => 'Resposta Incorreta',
        'always' => 'Sempre'
    
    );
    echo getHTMLSelectOptions($availableOptions, 'always');
    ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <span class="input-group-btn"><button type="button" class="btn btn-default btn-add">+</button></span>
                                        </div>
                                    </div>
                                </div>
    <?php
}

function printPreviewQuestion($questionId)
{
    global $db;

    $question = $db->getRow(
        sprintf("SELECT * FROM questions WHERE id='%d' LIMIT 1", $questionId)
    );

    if (is_null($question)) {
        // La pregunta que ens han passat no existeix, per tant tornem a mostrar la llista.
        $missatges[] = array(
            'type' => "error",
            'msg' => "Não há informações sobre essa pergunta."
        );
        printQuestionManagement($missatges);

        return false;
    }

    // get question's choices, if none, return
    $question['choices'] = $db->getAll(
        sprintf("SELECT * FROM questions_choices WHERE question_id='%d'", $questionId)
    );

    if (empty($question['image'])) {
        $question['image'] = 'images/question_default.jpg';
    }

    ?>
    <h1>Veure pregunta
    <a href="<?= $_SERVER['PHP_SELF']; ?>?a=editquiz&item=<?= $questionId; ?>" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit"></span> Editar</a>
    <a href="<?= $_SERVER['PHP_SELF']; ?>?a=quiz" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-retweet"></span> Voltar</a>
    </h1>

    <div class="panel panel-default" width="70%">
        <div class="panel-heading">
            <h2><?= $question['name']; ?></h2>
        </div>
        <div class="panel-body">
            <img src="<?= $question['image']; ?>" width="120" class="img-rounded">
            <h4><?= $question['question']; ?></h4>
                <ul class="list-group">
    <?php
    $htmlCode = array();
    foreach ($question['choices'] as $choice) {
        $htmlCode[] = '<li class="list-group-item">';
        if ('yes' == $choice['correct']) {
            $htmlCode[] = '<span class="glyphicon glyphicon-ok"></span>';
        } else {
            $htmlCode[] = '<span class="glyphicon glyphicon-remove"></span>';
        }
        $htmlCode[] = $choice['choice'];
        $htmlCode[] = '<span class="badge pull-right">' . $choice['points'] .'</span>';
        $htmlCode[] = '</li>';
    }
    echo implode(PHP_EOL, $htmlCode);
    ?>
                </ul>
    <?php
    if (!empty($question['solution'])) {
        // nomes mostrem la resposta si l'usuari ha respost la pregunta
        echo '<div class="alert alert-info"><p><strong>A resposta correta é: </strong></p><p>'. $question['solution'] .'</p></div>';
    }
    ?>
        </div>
    </div>
    <?php
}
