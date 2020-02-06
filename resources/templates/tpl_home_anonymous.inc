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
 * @package    Home for anonymous
 * @author     Paco Orozco <paco_@_pacoorozco.info> 
 * @license    http://www.gnu.org/licenses/gpl-2.0.html (GPL v2)
 * @link       https://github.com/pacoorozco/gamify
 */
?>
<div class="row">
    <div class="col-md-6">
        <h1>Bem Vindo ao Red Hat Rally!</h1>
        <p class="text-justify"> Uma nova experiência para aprender e desenvolver suas habilidades em OpenShift se divertindo e competindo!</p>


        <p class="text-justify">O <strong><abbr title="Game of Work">Red Hat Rally</abbr></strong>, é uma plataforma onde você poderá aprender e competir com outros jogadores sobre quem possuí maior habilidade em OpenShift. Isso lhe proporcionará níveis, badges e recompensas em cada estágio do jogo.<p>

    </div>

    <div class="col-md-6">
        <h1>Vamos jogar?</h1>
        <div id="loginbox">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Acessar</div>
                    <div style="float:right; position: relative; top:-10px"><a href="http://www.upcnet.es/CanviContrasenyaUPC" target="_blank">Esqueceu sua senha?</a></div>
                </div>

                <div style="padding-top:30px" class="panel-body" >
                    <form action="login.php" method="post" class="form-horizontal" role="form">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="<?= $usertext; ?>" required>
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="contrasenya" autocomplete="off" required>
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" id="a" name="a" value="login">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span> <?= $logintext; ?></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px;">
                                    No has accedit mai?
                                    <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                        Registra't ara!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="signupbox" style="display:none;">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Registre</div>
                    <div style="float:right; position: relative; top:-10px">
                        <a href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Já tem um usuário? Acesse!</a>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="login.php" method="post" class="form-horizontal" role="form">

                        <div id="signupalert" style="display:none" class="alert alert-danger">
                            <p>Error:</p>
                            <span></span>
                        </div>                    
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="<?= $usertext; ?>" required>
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Senha" autocomplete="off" required>
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" name="email" id="email" class="form-control" placeholder="E-mail" required>
                        </div>                        

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="hidden" id="a" name="a" value="do_register">
                                <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-hand-right"></span> Registrar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
