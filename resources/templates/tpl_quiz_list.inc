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
 * @package    Quiz List Questions
 * @author     Paco Orozco <paco_@_pacoorozco.info> 
 * @license    http://www.gnu.org/licenses/gpl-2.0.html (GPL v2)
 * @link       https://github.com/pacoorozco/gamify
 */
?>

<div class="panel panel-default" width="70%">
    <div class="panel-body">
        <div class="well">
            <h4>Pronto para as Perguntas?</h4>
            <p>As Perguntas são referentes ao OpenShift e como utilizar a ferramenta..</p>
            <p>Além disso, você ganhará pontos e badges para subir de nível, se vangloriar para seus colegas ou simplesmente se vencer.</p>
        </div>
        <h4>Suas perguntas pendentes</h4>
        <?= implode(PHP_EOL, $htmlCode); ?>
    </div>
</div>
