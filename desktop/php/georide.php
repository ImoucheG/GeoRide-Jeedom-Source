<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('georide');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>
<div class="row row-overflow">
    <div class="col-xs-12 eqLogicThumbnailDisplay">
        <legend><i class="fas fa-cog"></i> {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction logoPrimary" data-action="add">
                <i class="fas fa-plus-circle" style="color: orange"></i>
                <br>
                <span>{{Ajouter un boitier}}</span>
            </div>
            <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
                <i class="fas fa-wrench" style="color: lightblue"></i>
                <br>
                <span>{{Configuration}}</span>
            </div>
        </div>
        <legend><i class="fas fa-table"></i> {{Mes boitiers}}</legend>
        <input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic"/>
        <div class="eqLogicThumbnailContainer">
            <?php
            foreach ($eqLogics as $eqLogic) {
                $opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
                echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
                echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
                echo '<br>';
                echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div oninit class="col-xs-12 eqLogic" style="display: none;">
        <div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a
                        class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a
                        class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a
                        class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab"
                                       data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
            <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i
                            class="fa fa-tachometer"></i> {{Equipement}}</a></li>
            <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i
                            class="fa fa-list-alt"></i> {{Commandes}}</a></li>
        </ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                <br/>
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Nom du boitier}}</label>
                            <div class="col-sm-3">
                                <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;"/>
                                <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom du boitier}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Objet parent}}</label>
                            <div class="col-sm-3">
                                <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                                    <option value="">{{Aucun}}</option>
                                    <?php
                                    foreach (jeeObject::all() as $object) {
                                        echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Catégorie}}</label>
                            <div class="col-sm-9">
                                <?php
                                foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                    echo '<label class="checkbox-inline">';
                                    echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                    echo '</label>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                                <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Boitier (Tracker ID)}}</label>
                            <div class="col-sm-3">
                                <input id="TrackerID" type="text" class="eqLogicAttr form-control" data-l1key="configuration"
                                       data-l2key="trackerId" placeholder="Tracker ID"/>
                                <table class="table table-striped col-lg-12 col-md-12 col-xs-12">
                                    <thead>
                                    <td>{{Tacker ID}}</td>
                                    <td>{{Nom du boitier}}</td>
                                    </thead>
                                    <tbody id="ListTrackers">
                                    <tr>
                                        <td colspan="2"><font style="font-style: italic;">{{Liste vide}}</font></td>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-info col-lg-12"
                                        onclick="getGeorideBox(event, '<?php echo config::byKey('APIToken', 'georide') ?>')">{{Actualiser la
                                    liste des boitiers}}
                                </button>
                                <label class="col-sm-4 control-label">{{GeoLoc URL}}</label>
                                <span class="col-lg-12 italic" style="font-style: italic;">{{GeoLoc est un plug-in Jeedom (<a
                                            href='https://jeedom.github.io/plugin-geoloc/fr_FR/'>https://jeedom.github.io/plugin-geoloc/fr_FR/</a>).
            Si vous souhaitez mettre à jour vos coordonnées Jeedom, merci de remplir le champ suivant sinon vous pouvez le laisser vide pour désactiver la fonction.}}</span>
                                <input id="GeoLocUrl" type="text" class="eqLogicAttr form-control" data-l1key="configuration"
                                       data-l2key="geolocUrl"
                                       placeholder="https://myUrlJeedom.com/plugins/geoloc/core/api/jeeGeoloc.php?apikey=myAPiKey&id=myIdCmd&value=%LOCN"/>
                                <span class="col-lg-12" style="font-style: italic;">{{Example: https://myUrlJeedom.com/plugins/geoloc/core/api/jeeGeoloc.php?apikey=myAPiKey&id=myIdCmd&value=%LOCN Pour plus d'information veuillez consulter
            la documentation de GeoLoc, l'url peut être retrouver au sein de l'onglet "Commandes" de votre équipement GeoLoc, <font
                                            style="font-style: italic; font-weight: bold;color: red">!IMPORTANT! merci de ne pas changer %LOCN au sein de l'URL, il sera complété dynamiquement.</font> Vous pouvez remplacer votre IP/DOMAIN WAN (myUrlJeedom.com) par votre IP LAN si nécessaire.}} </span>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="commandtab">
                <a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"><i
                            class="fa fa-plus-circle"></i> {{Commandes}}</a><br/><br/>
                <table id="table_cmd" class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>{{Nom}}</th>
                        <th>{{Type}}</th>
                        <th>{{Action}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include_file('desktop', 'georide', 'js', 'georide'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
