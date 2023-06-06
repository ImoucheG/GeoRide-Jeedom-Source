/* This file is part of GeoRide-.
 *
 * GeoRide-Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GeoRide- is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

$("#table_cmd").sortable({
  axis: "y",
  cursor: "move",
  items: ".cmd",
  placeholder: "ui-state-highlight",
  tolerance: "intersect",
  forcePlaceholderSize: true
});

function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = {configuration: {}};
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {};
  }
  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
  tr += '<td>';
  tr += '<span class="cmdAttr" data-l1key="id" style="display:none;"></span>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" style="width : 140px;" placeholder="{{Nom}}">';
  tr += '</td>';
  tr += '<td>';
  tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
  tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
  tr += '</td>';
  tr += '<td>';
  tr += '<span><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isHistorized" /> {{Historiser}}<br/></span>';
  tr += '<span><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isVisible" /> {{Affichage}}<br/></span>';
  tr += '</td>';
  tr += '<td>';
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
  }
  tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
  tr += '</td>';
  tr += '</tr>';
  $('#table_cmd tbody').append(tr);
  $('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
  if (isset(_cmd.type)) {
    $('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
  }
  jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
}

/*
 * Get box on georide account
 */
function getGeorideBox(event, APIToken) {
  event.preventDefault();
  $.ajax
  ({
    type: "GET",
    url: "https://api.georide.fr/user/trackers",
    headers: {
      "Authorization": "Bearer " + APIToken
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert('{{Erreur lors de la récupération des trackers, veuillez vérifier votre clée API ou le status de api.georide.fr.}} Code: ' + XMLHttpRequest.responseJSON.error);
    },
    success: function (data) {
      var lines = '';
      for (var i = 0; i < data.length; i++) {
        lines += '<tr style="cursor: pointer" class="lines-tracker" attr-id="' + data[i].trackerId + '"><td>' + data[i].trackerId + '</td><td>' + data[i].trackerName + '<td></tr>';
      }
      $('#ListTrackers').html(lines);
      setTimeout(() => {
        $('.lines-tracker').click((e) => {
          $('.selected-tracker').css('color', 'black');
          $('.selected-tracker').removeClass('selected-tracker');
          $(e.target.parentNode).addClass('selected-tracker');
          $('.selected-tracker').css('color', 'orange');
          document.getElementById('TrackerID').value = e.target.parentNode.getAttribute('attr-id');
        });
      }, 500);
    }
  });
}

/*
 * API Key
 */
function getAPIKey(event) {
  event.preventDefault();
  $.ajax
  ({
    type: "POST",
    url: "https://api.georide.fr/user/login",
    data: {
      email: document.getElementById('EmailGeoRide').value,
      password: document.getElementById('PasswordGeoRide').value
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert('{{Erreur lors de la récupération de la clée API, veuillez vérifier vos données ou le status de api.georide.fr.}} Code: ' + XMLHttpRequest.responseJSON.error);
    },
    success: function (data) {
      document.getElementById('APIToken').value = data.authToken;
    }
  });
}
