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
 * @package    Home for members
 * @author     Paco Orozco <paco_@_pacoorozco.info> 
 * @license    http://www.gnu.org/licenses/gpl-2.0.html (GPL v2)
 * @link       https://github.com/pacoorozco/gamify
 */
?>
<div class="row">

    <div class="col-md-6">
        <h1>Vamos Jogar?</h1>
        <p class="lead">Bem Vindo ao <strong>Red Hat Rally!</strong></p>
        
        <ul class="nav nav-pills" role="tablist">
                <li class="active"><a href="#gow" role="tab" data-toggle="tab">O que é o Red Hat Rally?</a></li>
        </ul>

        <p>&nbsp;</p>

        <div class="tab-content">

                <div class="tab-pane active" id="gow">
                        <div class="video-container"> 
                                <iframe width="320" height="240" src="//www.youtube.com/embed/5dwMrFxq8sU" allowfullscreen></iframe>
                        </div>
                </div>
        </div>


    </div>

    <div class="col-md-6">
        <h1>Pesquisar Jogador</h1>
        <form method="get" action="#" role="form">
            <div class="input-group custom-search-form">
                <input type="text" name="q" id="live-search" class="form-control" placeholder="Procurar Jogador">
                <input type="hidden" name="a" value="search">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>

        <h1>Hall da Fama</h1>

        <ul class="nav nav-tabs">
            <li class="active"><a href="#month_top" data-toggle="tab">No mês</a></li>
            <li><a href="#top" data-toggle="tab">Total</a></li>
            <li><a href="#top10" data-toggle="tab">Top 10</a></li>
        </ul>

        <div class="tab-content">
            <!-- month top -->
            <div class="table-responsive tab-pane fade in active" id="month_top">
                <table class="table table-hover" >
                    <thead>
                        <tr>
                            <th class="text-center">Posição</th>
                            <th>Nome</th>
                            <th>Experiência</th>
                            <th>Nível</th>
                            <th class="text-center">Badges</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= implode(PHP_EOL, $htmlMonthTop); ?>
                    </tbody>
                </table>
            </div>

            <!-- top -->
            <div class="table-responsive tab-pane fade active" id="top">
                <table class="table table-hover" >
                    <thead>
                        <tr>
                            <th class="text-center">Posição</th>
                            <th>Nome</th>
                            <th>Experiência</th>
                            <th>Nível</th>
                            <th class="text-center">Badges</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= implode(PHP_EOL, $htmlTop); ?>
                    </tbody>
                </table>
            </div>

            <!-- top10 -->
            <div class="table-responsive tab-pane fade active" id="top10">
                <table class="table table-hover" >
                    <thead>
                        <tr>
                            <th class="text-center">Posição</th>
                            <th>Nome</th>
                            <th>Experiência</th>
                            <th>Nível</th>
                            <th class="text-center">Badges</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= implode(PHP_EOL, $htmlTop10); ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
