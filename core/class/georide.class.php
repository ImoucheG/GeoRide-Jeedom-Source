<?php

/*
 * GeoRide-Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GeoRide-Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class georide extends eqLogic {
    /*
     * Executed every minute
     */
    public static function cron($_eqLogic_id = null) {
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('georide', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
        foreach ($eqLogics as $georide) {
            if ($georide->getIsEnable() == 1) {
                $cmd = $georide->getCmd(null, 'refresh');
                if (!is_object($cmd)) {
                    continue;
                }
                $cmd->execCmd();
            }
        }
    }

    /*
     * Executed every 5 minutes
     */
    public static function cron5($_eqLogic_id = null) {
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('georide', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
        foreach ($eqLogics as $georide) {
            if ($georide->getIsEnable() == 1) {
                $cmd = $georide->getCmd(null, 'refresh');
                if (!is_object($cmd)) {
                    continue;
                }
                $cmd->execCmd();
            }
        }
    }

    /*
     * Executed every 10 minutes
     */
    public static function cron10($_eqLogic_id = null) {
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('georide', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
        foreach ($eqLogics as $georide) {
            if ($georide->getIsEnable() == 1) {
                $cmd = $georide->getCmd(null, 'refresh');
                if (!is_object($cmd)) {
                    continue;
                }
                $cmd->execCmd();
            }
        }
    }

    /*
     * Executed every 15 minutes
     */
    public static function cron15($_eqLogic_id = null) {
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('georide', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
        foreach ($eqLogics as $georide) {
            if ($georide->getIsEnable() == 1) {
                $cmd = $georide->getCmd(null, 'refresh');
                if (!is_object($cmd)) {
                    continue;
                }
                $cmd->execCmd();
            }
        }
    }

    /*
     * Executed every 30 minutes
     */
    public static function cron30($_eqLogic_id = null) {
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('georide', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
        foreach ($eqLogics as $georide) {
            if ($georide->getIsEnable() == 1) {
                $cmd = $georide->getCmd(null, 'refresh');
                if (!is_object($cmd)) {
                    continue;
                }
                $cmd->execCmd();
            }
        }
    }

    public static function cronHourly($_eqLogic_id = null) {
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('georide', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
        foreach ($eqLogics as $georide) {
            if ($georide->getIsEnable() == 1) {
                $cmd = $georide->getCmd(null, 'refresh');
                if (!is_object($cmd)) {
                    continue;
                }
                $cmd->execCmd();
            }
        }
    }

    /* Get informations of tracker called by refresh in cron and command */
    public function getInformations() {
        $trackerId = $this->getConfiguration("trackerId");
        // Locked status
        $opts = array('http' =>
            array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . config::byKey('APIToken', 'georide')
            )
        );
	
        $context = stream_context_create($opts);
        $result = file_get_contents('https://api.georide.fr/user/trackers', false, $context);
	
        // Debug
        //log::add(__CLASS__, 'debug', '[' . __FUNCTION__ . '] ' . __('$result::'$result, __FILE__));
        log::add(__CLASS__, 'debug', '[' . __FUNCTION__ . '] ' . __('$result::'. $result, __FILE__));

        $jsonResult = json_decode($result);
        $eqTracker = NULL;
        foreach ($jsonResult as &$tracker) {
            if ($tracker->trackerId == $trackerId) {
                $eqTracker = $tracker;
                break;
            }
        }
	    
	// Debug
      	log::add(__CLASS__, 'debug', '[' . __FUNCTION__ . '] ' . __('$eqTracker::Data tracker id "'. $trackerId .'" reçue : ' . json_encode($eqTracker), __FILE__));
	
        $this->checkAndUpdateCmd('lockedStatus', $eqTracker->isLocked);
        $this->checkAndUpdateCmd('locationLongitude', $eqTracker->longitude);
        $this->checkAndUpdateCmd('locationLatitude', $eqTracker->latitude);
        $this->checkAndUpdateCmd('lastTimeLocation', $eqTracker->fixtime);
        $this->checkAndUpdateCmd('trackerName', $eqTracker->trackerName);
        $this->checkAndUpdateCmd('deviceButtonAction', $eqTracker->deviceButtonAction);
        $this->checkAndUpdateCmd('vibrationLevel', $eqTracker->vibrationLevel);
        $this->checkAndUpdateCmd('role', $eqTracker->role);
        $this->checkAndUpdateCmd('lastPaymentDate', $eqTracker->lastPaymentDate);
        $this->checkAndUpdateCmd('equipmentMeter', ($eqTracker->odometer / 1000));
        $this->checkAndUpdateCmd('odometer', $eqTracker->odometer);
        $this->checkAndUpdateCmd('isStolen', $eqTracker->isStolen);
        $this->checkAndUpdateCmd('isCrashed', $eqTracker->isCrashed);
        $this->checkAndUpdateCmd('speed', $eqTracker->speed);
        $this->checkAndUpdateCmd('moving', $eqTracker->moving);
        $this->checkAndUpdateCmd('online', $eqTracker->status);
        $this->checkAndUpdateCmd('isSecondGen', $eqTracker->isSecondGen);
        $this->checkAndUpdateCmd('externalBatteryVoltage', $eqTracker->externalBatteryVoltage);
        $this->checkAndUpdateCmd('internalBatteryVoltage', $eqTracker->internalBatteryVoltage);
	    
        $geoLocUrl = $this->getConfiguration("geolocUrl");
        if (strlen($geoLocUrl) > 10) {
            $geoLocUrl = str_replace('%LOCN', $eqTracker->latitude . ',' . $eqTracker->longitude, $geoLocUrl);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $geoLocUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
        if (strlen($geoLocUrl) <= 10 && strlen($geoLocUrl) > 1) {
            log::add('GeoRide', 'error', 'GeoLoc URL est incorrect');
        }
        sleep(3);
        $this->refreshWidget();
    }

    /* Unlock the tracker */
    public function unlockTracker() {
        $trackerId = $this->getConfiguration("trackerId");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.georide.fr/tracker/' . $trackerId . '/unlock');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . config::byKey('APIToken', 'georide')));
        curl_exec($ch);
        curl_close($ch);
        $this->getInformations();
    }

    /* Lock the tracker */
    public function lockTracker() {
        $trackerId = $this->getConfiguration("trackerId");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.georide.fr/tracker/' . $trackerId . '/lock');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . config::byKey('APIToken', 'georide')));
        curl_exec($ch);
        curl_close($ch);
        $this->getInformations();
    }

    public function preInsert(){}

    public function postInsert(){}

    public function preSave(){}

    public function postSave() {
        $info = $this->getCmd(null, 'lockedStatus');
        if (!is_object($info)) {
            $info = new georideCmd();
            $info->setName(__('Locked', __FILE__));
        }
        $info->setLogicalId('lockedStatus');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setTemplate('dashboard', 'georide');
        $info->setDisplay("showNameOndashboard", 1);
        $info->setSubType('numeric');
        $info->save();

        $trackerName = $this->getCmd(null, 'trackerName');
        if (!is_object($trackerName)) {
            $trackerName = new georideCmd();
            $trackerName->setName(__('Tracker name', __FILE__));
        }
        $trackerName->setLogicalId('trackerName');
        $trackerName->setEqLogic_id($this->getId());
        $trackerName->setType('info');
        $trackerName->setTemplate('dashboard', 'georide');
        $trackerName->setDisplay("showNameOndashboard", 0);
        $trackerName->setSubType('string');
        $trackerName->save();

        $deviceButtonAction = $this->getCmd(null, 'deviceButtonAction');
        if (!is_object($deviceButtonAction)) {
            $deviceButtonAction = new georideCmd();
            $deviceButtonAction->setName(__('Button action', __FILE__));
        }
        $deviceButtonAction->setLogicalId('deviceButtonAction');
        $deviceButtonAction->setEqLogic_id($this->getId());
        $deviceButtonAction->setType('info');
        $deviceButtonAction->setTemplate('dashboard', 'georide');
        $deviceButtonAction->setDisplay("showNameOndashboard", 1);
        $deviceButtonAction->setSubType('string');
        $deviceButtonAction->save();

        $vibrationLevel = $this->getCmd(null, 'vibrationLevel');
        if (!is_object($vibrationLevel)) {
            $vibrationLevel = new georideCmd();
            $vibrationLevel->setName(__('Vibration level', __FILE__));
        }
        $vibrationLevel->setLogicalId('vibrationLevel');
        $vibrationLevel->setEqLogic_id($this->getId());
        $vibrationLevel->setType('info');
        $vibrationLevel->setTemplate('dashboard', 'georide');
        $vibrationLevel->setDisplay("showNameOndashboard", 1);
        $vibrationLevel->setSubType('numeric');
        $vibrationLevel->save();


        $role = $this->getCmd(null, 'role');
        if (!is_object($role)) {
            $role = new georideCmd();
            $role->setName(__('Role', __FILE__));
        }
        $role->setLogicalId('role');
        $role->setEqLogic_id($this->getId());
        $role->setType('info');
        $role->setTemplate('dashboard', 'georide');
        $role->setDisplay("showNameOndashboard", 1);
        $role->setSubType('string');
        $role->save();

        $lastPaymentDate = $this->getCmd(null, 'lastPaymentDate');
        if (!is_object($lastPaymentDate)) {
            $lastPaymentDate = new georideCmd();
            $lastPaymentDate->setName(__('Last payment', __FILE__));
        }
        $lastPaymentDate->setLogicalId('lastPaymentDate');
        $lastPaymentDate->setEqLogic_id($this->getId());
        $lastPaymentDate->setType('info');
        $lastPaymentDate->setTemplate('dashboard', 'georide');
        $lastPaymentDate->setDisplay("showNameOndashboard", 1);
        $lastPaymentDate->setSubType('string');
        $lastPaymentDate->save();

        $odometer = $this->getCmd(null, 'odometer');
        if (!is_object($odometer)) {
            $odometer = new georideCmd();
            $odometer->setName(__('Odometer', __FILE__));
        }
        $odometer->setLogicalId('odometer');
        $odometer->setEqLogic_id($this->getId());
        $odometer->setType('info');
        $odometer->setTemplate('dashboard', 'georide');
        $odometer->setDisplay("showNameOndashboard", 1);
        $odometer->setSubType('numeric');
        $odometer->save();

        $equipmentMeter = $this->getCmd(null, 'equipmentMeter');
        if (!is_object($equipmentMeter)) {
            $equipmentMeter = new georideCmd();
            $equipmentMeter->setName(__('Meter', __FILE__));
        }
        $equipmentMeter->setLogicalId('equipmentMeter');
        $equipmentMeter->setEqLogic_id($this->getId());
        $equipmentMeter->setType('info');
        $equipmentMeter->setTemplate('dashboard', 'georide');
        $equipmentMeter->setDisplay("showNameOndashboard", 1);
        $equipmentMeter->setSubType('numeric');
        $equipmentMeter->save();

        $isStolen = $this->getCmd(null, 'isStolen');
        if (!is_object($isStolen)) {
            $isStolen = new georideCmd();
            $isStolen->setName(__('Stolen', __FILE__));
        }
        $isStolen->setLogicalId('isStolen');
        $isStolen->setEqLogic_id($this->getId());
        $isStolen->setType('info');
        $isStolen->setTemplate('dashboard', 'georide');
        $isStolen->setDisplay("showNameOndashboard", 1);
        $isStolen->setSubType('numeric');
        $isStolen->save();

        $isCrashed = $this->getCmd(null, 'isCrashed');
        if (!is_object($isCrashed)) {
            $isCrashed = new georideCmd();
            $isCrashed->setName(__('Crashed', __FILE__));
        }
        $isCrashed->setLogicalId('isCrashed');
        $isCrashed->setEqLogic_id($this->getId());
        $isCrashed->setType('info');
        $isCrashed->setTemplate('dashboard', 'georide');
        $isCrashed->setDisplay("showNameOndashboard", 1);
        $isCrashed->setSubType('numeric');
        $isCrashed->save();

        $speed = $this->getCmd(null, 'speed');
        if (!is_object($speed)) {
            $speed = new georideCmd();
            $speed->setName(__('Speed', __FILE__));
        }
        $speed->setLogicalId('speed');
        $speed->setEqLogic_id($this->getId());
        $speed->setType('info');
        $speed->setTemplate('dashboard', 'georide');
        $speed->setDisplay("showNameOndashboard", 1);
        $speed->setSubType('numeric');
        $speed->save();

        $moving = $this->getCmd(null, 'moving');
        if (!is_object($moving)) {
            $moving = new georideCmd();
            $moving->setName(__('Moving', __FILE__));
        }
        $moving->setLogicalId('moving');
        $moving->setEqLogic_id($this->getId());
        $moving->setType('info');
        $moving->setTemplate('dashboard', 'georide');
        $moving->setDisplay("showNameOndashboard", 1);
        $moving->setSubType('numeric');
        $moving->save();

        $online = $this->getCmd(null, 'online');
        if (!is_object($online)) {
            $online = new georideCmd();
            $online->setName(__('Online', __FILE__));
        }
        $online->setLogicalId('online');
        $online->setEqLogic_id($this->getId());
        $online->setType('info');
        $online->setTemplate('dashboard', 'georide');
        $online->setDisplay("showNameOndashboard", 0);
        $online->setSubType('string');
        $online->save();

	$isSecondGen = $this->getCmd(null, 'isSecondGen');
        if (!is_object($isSecondGen)) {
            $isSecondGen = new georideCmd();
            $isSecondGen->setName(__('GeoRide 3', __FILE__));
        }
        $isSecondGen->setLogicalId('isSecondGen');
        $isSecondGen->setEqLogic_id($this->getId());
        $isSecondGen->setType('info');
        $isSecondGen->setTemplate('dashboard', 'georide');
        $isSecondGen->setDisplay("showNameOndashboard", 0);
        $isSecondGen->setSubType('numeric');
        $isSecondGen->save();

	$externalBatteryVoltage = $this->getCmd(null, 'externalBatteryVoltage');
        if (!is_object($externalBatteryVoltage)) {
            $externalBatteryVoltage = new georideCmd();
            $externalBatteryVoltage->setName(__('External battery voltage', __FILE__));
        }
        $externalBatteryVoltage->setLogicalId('externalBatteryVoltage');
        $externalBatteryVoltage->setEqLogic_id($this->getId());
        $externalBatteryVoltage->setType('info');
        $externalBatteryVoltage->setTemplate('dashboard', 'georide');
        $externalBatteryVoltage->setDisplay("showNameOndashboard", 0);
        $externalBatteryVoltage->setSubType('numeric');
        $externalBatteryVoltage->save();

	$internalBatteryVoltage = $this->getCmd(null, 'internalBatteryVoltage');
        if (!is_object($internalBatteryVoltage)) {
            $internalBatteryVoltage = new georideCmd();
            $internalBatteryVoltage->setName(__('Internal battery voltage', __FILE__));
        }
        $internalBatteryVoltage->setLogicalId('internalBatteryVoltage');
        $internalBatteryVoltage->setEqLogic_id($this->getId());
        $internalBatteryVoltage->setType('info');
        $internalBatteryVoltage->setTemplate('dashboard', 'georide');
        $internalBatteryVoltage->setDisplay("showNameOndashboard", 0);
        $internalBatteryVoltage->setSubType('numeric');
        $internalBatteryVoltage->save();

        $locationLongitude = $this->getCmd(null, 'locationLongitude');
        if (!is_object($locationLongitude)) {
            $locationLongitude = new georideCmd();
            $locationLongitude->setName(__('Longitude', __FILE__));
        }
        $locationLongitude->setLogicalId('locationLongitude');
        $locationLongitude->setEqLogic_id($this->getId());
        $locationLongitude->setType('info');
        $locationLongitude->setTemplate('dashboard', 'georide');
        $locationLongitude->setDisplay("showNameOndashboard", 1);
        $locationLongitude->setSubType('string');
        $locationLongitude->save();

        $locationLatitude = $this->getCmd(null, 'locationLatitude');
        if (!is_object($locationLatitude)) {
            $locationLatitude = new georideCmd();
            $locationLatitude->setName(__('Latitude', __FILE__));
        }
        $locationLatitude->setLogicalId('locationLatitude');
        $locationLatitude->setEqLogic_id($this->getId());
        $locationLatitude->setType('info');
        $locationLatitude->setTemplate('dashboard', 'georide');
        $locationLatitude->setDisplay("showNameOndashboard", 1);
        $locationLatitude->setSubType('string');
        $locationLatitude->save();

        $lastTimeLocation = $this->getCmd(null, 'lastTimeLocation');
        if (!is_object($lastTimeLocation)) {
            $lastTimeLocation = new georideCmd();
            $lastTimeLocation->setName(__('Last location time', __FILE__));
        }
        $lastTimeLocation->setLogicalId('lastTimeLocation');
        $lastTimeLocation->setEqLogic_id($this->getId());
        $lastTimeLocation->setType('info');
        $lastTimeLocation->setTemplate('dashboard', 'georide');
        $lastTimeLocation->setDisplay("showNameOndashboard", 1);
        $lastTimeLocation->setSubType('string');
        $lastTimeLocation->save();

        $refresh = $this->getCmd(null, 'refresh');
        if (!is_object($refresh)) {
            $refresh = new georideCmd();
            $refresh->setName(__('Refresh', __FILE__));
        }
        $refresh->setEqLogic_id($this->getId());
        $refresh->setLogicalId('refresh');
        $refresh->setType('action');
        $refresh->setSubType('other');
        $refresh->save();

        $unlock = $this->getCmd(null, 'unlock');
        if (!is_object($unlock)) {
            $unlock = new georideCmd();
            $unlock->setName(__('Unlock', __FILE__));
        }
        $unlock->setEqLogic_id($this->getId());
        $unlock->setLogicalId('unlock');
        $unlock->setType('action');
        $unlock->setSubType('other');
        $unlock->save();

        $lock = $this->getCmd(null, 'lock');
        if (!is_object($lock)) {
            $lock = new georideCmd();
            $lock->setName(__('Lock', __FILE__));
        }
        $lock->setEqLogic_id($this->getId());
        $lock->setLogicalId('lock');
        $lock->setType('action');
        $lock->setSubType('other');
        $lock->save();
    }

    public function toHtml($_version = 'dashboard') {
        $replace = $this->preToHtml($_version);
        if (!is_array($replace)) {
            return $replace;
        }
        $version = jeedom::versionAlias($_version);
        foreach ($this->getCmd('info') as $cmd) {
            if ($cmd->getLogicalId() == 'lockedStatus') {
                if ($cmd->execCmd() == '1') {
                    $replace['#lock_unlock_id#'] = '#unlock_id#';
                    $replace['#title-lock-unlock#'] = 'Déverrouiller';
                    $replace['#fa-lock-unlock#'] = 'fa-lock';
                }
                if ($cmd->execCmd() == '0') {
                    $replace['#lock_unlock_id#'] = '#lock_id#';
                    $replace['#title-lock-unlock#'] = 'Verrouiller';
                    $replace['#fa-lock-unlock#'] = 'fa-lock-open';
                }
            }
            if ($cmd->getLogicalId() == 'moving') {
                if ($cmd->execCmd() == '1') {
                    $replace['#fa-walking#'] = 'fa-walking';
                    $replace['#title-movemen#'] = 'En mouvement';
                }
                if ($cmd->execCmd() == '0') {
                    $replace['#fa-walking#'] = 'fa-male';
                    $replace['#title-movement#'] = 'Statique';
                }
            }
            if ($cmd->getLogicalId() == 'speed') {
                $replace['#speed_convert#'] = $cmd->execCmd() / 1000;
            }
            if ($cmd->getLogicalId() == 'online') {
                if ($cmd->execCmd() == 'online') {
                    $replace['#fa-signal#'] = 'fa-signal';
                    $replace['#title-status#'] = 'En ligne';
                }
                if ($cmd->execCmd() == 'offline') {
                    $replace['#fa-signal#'] = 'fa-exclamation-triangle';
                    $replace['#title-status#'] = 'Statique';
                }
            }
            if ($cmd->getLogicalId() == 'trackerName') {
                $replace['#eqname#'] = $cmd->execCmd();
            }
            $replace['#' . $cmd->getLogicalId() . '#'] = $cmd->execCmd();
            $replace['#eqid#'] = $this->getId();
        }
        foreach ($this->getCmd('action') as $cmd) {
            $replace['#' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
        }

        return template_replace($replace, getTemplate('core', $version, 'georide', 'georide'));
    }

    public function preUpdate(){}

    public function postUpdate(){
    	if ($this->getIsEnable() == 1) {
	        $cmd = $this->getCmd(null, 'refresh');
	        if (is_object($cmd)) {
	            $cmd->execCmd();
	        }
	        self::cron($this->getId());
	    }
    }

    public function preRemove(){}

    public function postRemove(){}
}

class georideCmd extends cmd {
    public function execute($_options = array())
    {
        $eqlogic = $this->getEqLogic();
        switch ($this->getLogicalId()) {
            case 'refresh':
                $eqlogic->getInformations();
                break;
            case 'unlock':
                $eqlogic->unlockTracker();
                break;
            case 'lock':
                $eqlogic->lockTracker();
                break;
        }
    }
}
