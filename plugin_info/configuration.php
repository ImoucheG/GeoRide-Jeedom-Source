<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
?>
<form class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Authentification API Key}}</label>
            <div class="col-lg-2">
                <input class="configKey form-control" data-l1key="APIToken" id="APIToken" />
                <span style="color: red; font-style: italic;">{{Après la sauvegarde, merci de rafraichir entièrement votre page à l'aide d'un F5}}</span>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12">
                <h3>{{Récupérer la clé API}}</h3>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="col-lg-5 col-md-5 col-xs-5">
                        <input class="configKey form-control" data-l1key="emailGeoride" id="EmailGeoRide" type="email" placeholder="{{Email}}"/>
                    </div>
                    <div class="col-lg-5 col-md-5 col-xs-5">
                        <input class="configKey form-control" data-l1key="passwordGeoride" id="PasswordGeoRide" type="password" placeholder="{{Mot de passe}}"/>
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-2">
                        <button type="button" class="btn btn-info" onclick="getAPIKey(event)">{{Récupérer}}</button>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>


<?php include_file('desktop', 'georide', 'js', 'georide'); ?>
