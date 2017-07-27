<?php header('Access-Control-Allow-Origin: *'); ?>
<script type="text/ng-template" id="tpl/map.html">
    <div ng-controller="mapCtrl" id="map" touch-tooltips force-touch-tooltips="true" class="mapContainer">
	<div class="sidebar zoomBar">
		<div class="mainLayoutMenuButton directionTo withArrowTip zoomButton zoomIn"
			 clickable="zoom(zoomLevel-1);"
			 ng-class="{disabled: zoomLevel == 0}"
			 tooltip
			 tooltip-translate="Map.ZoomIn"
			 tooltip-placement="after"
			 play-on-click="{{UISound.BUTTON_ZOOM_IN}}">
			<i class="action_zoomIn_small_flat_black"></i>
		</div>
		<div class="mainLayoutMenuButton directionTo withArrowTip zoomButton zoomOut"
			 clickable="zoom(zoomLevel+1);"
			 ng-class="{disabled: zoomLevel == 2}"
			 tooltip
			 tooltip-translate="Map.ZoomOut"
			 tooltip-placement="after"
			 play-on-click="{{UISound.BUTTON_ZOOM_OUT}}">
			<i class="action_zoomOut_small_flat_black"></i>
		</div>
		<div class="zoomLevel">
			<i class="currentZoomLevel sideMenu_zoomLevel{{zoomLevel+1}}_small_flat_black"></i>
		</div>

		<div class="mainLayoutMenuButton directionTo filterButton" ng-class="{active: filters.showFilters}">
			<div class="buttonWrapper"
				 clickable="filters.showFilters = !filters.showFilters; goToLocation.show = false;"
				 tooltip
				 tooltip-translate="Map.Filter"
				 tooltip-placement="after"
				 tooltip-hide="{{filters.showFilters}}">
				<i class="sideMenu_filter_small_flat_black"></i>
			</div>
			<div class="filters" ng-show="filters.showFilters">
				<div class="content">
					<div ng-if="zoomLevel != 2">
						<div class="headline" translate>Map.Filters.Title</div>
						<div class="option">
							<label>
								<input type="checkbox" ng-model="filters.borders" ng-change="setFilter('borders', filters.borders)"/>
								<span translate>Map.Filters.Borders</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="checkbox" ng-model="filters.markers" ng-change="setFilter('markers', filters.markers)"/>
								<span translate>Map.Filters.Markers</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="checkbox" ng-model="filters.mainVillages" ng-change="setFilter('mainVillages', filters.mainVillages)"/>
								<span translate>Map.Filters.MainVillages</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="checkbox" ng-model="filters.fieldMarkersGlobal" ng-change="setFilter('fieldMarkersGlobal', filters.fieldMarkersGlobal)"/>
								<span translate>Map.Filters.FieldMarkersGlobal</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="checkbox" ng-model="filters.fieldMarkersPersonal" ng-change="setFilter('fieldMarkersPersonal', filters.fieldMarkersPersonal)"/>
								<span translate>Map.Filters.FieldMarkersPersonal</span>
							</label>
						</div>
					</div>
					<div ng-if="zoomLevel == 2">
						<div class="headline" translate>Map.Filters.Title</div>
						<div class="option">
							<label>
								<input type="radio" value="0" ng-model="filters.heatmap" ng-change="setFilter('heatmap', filters.heatmap)"/>
								<span translate>Map.Filters.StrategicMap</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="radio" value="4" ng-model="filters.heatmap" ng-change="setFilter('heatmap', filters.heatmap)"/>
								<span translate>Map.Filters.PopulationMap</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="radio" value="5" ng-model="filters.heatmap" ng-change="setFilter('heatmap', filters.heatmap)"/>
								<span translate>Map.Filters.FightMap</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="radio" value="6" ng-model="filters.heatmap" ng-change="setFilter('heatmap', filters.heatmap)"/>
								<span translate>Map.Filters.Treasures</span>
							</label>
						</div>
						<div class="option">
							<label>
								<input type="checkbox" ng-model="filters.cropFinder" ng-change="setFilter('cropFinder', filters.cropFinder)"/>
								<span translate>Map.Filters.CropFinder</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mainLayoutMenuButton directionTo goToButton" ng-class="{active: goToLocation.show}">
			<div class="buttonWrapper"
				 clickable="goTo();"
				 tooltip
				 tooltip-translate="Map.GoToLocation"
				 tooltip-placement="after"
				 tooltip-hide="{{goToLocation.show}}">
				<i class="sideMenu_goTo_small_flat_black"></i>
			</div>
			<div class="filters" ng-show="goToLocation.show">
				<div class="content">
					<div class="header">
						<span translate>Map.GoToLocation</span>
						<i clickable="goHome()"
						   ng-class="{village_jumpTo_small_flat_black: !jumpToHover, village_jumpTo_small_flat_green: jumpToHover}"
						   on-pointer-over="jumpToHover = true" on-pointer-out="jumpToHover = false"
						   tooltip tooltip-translate="Map.GoHome"></i>
					</div>
					<serverautocomplete
						autocompletedata="village,playerVillages,allianceVillages,coords,emptyCoords"
						last-search-data-obj="goToLocation.searchObj"
						autocompletecb="goToLocation.jump"
						ng-model="goToLocation.model"
						input-autofocus="true"></serverautocomplete>
					<i class="centerResult"
					   ng-class="{symbol_target_small_flat_black: !targetHover, symbol_target_small_flat_green: targetHover}"
					   on-pointer-over="targetHover = true" on-pointer-out="targetHover = false"
					   clickable="goToLocation.jump(true)"
					   tooltip tooltip-translate="Map.GoToLocation"
					   ng-show="goToLocation.searchObj.data.length > 0"></i>
					<div class="footer" ng-show="goToLocation.searchObj.data.length > 1">
						<span translate data="currentIndex: {{goToLocation.index}}, countResults: {{goToLocation.searchObj.data.length}}">Map.resultsFound</span>
						<span class="arrowButtonContainer">
							<a class="arrowButton"
							   clickable="goToLocation.backward()"
							   ng-class="{disabled: goToLocation.index <= 1}"
							   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
								<i ng-class="{
									symbol_arrowFrom_tiny_flat_black: !fromHover || goToLocation.index <= 1,
									symbol_arrowFrom_tiny_flat_green: fromHover && goToLocation.index > 1
								}"></i>
							</a>
							<a class="arrowButton"
							   clickable="goToLocation.forward()"
							   ng-class="{disabled: goToLocation.index == goToLocation.searchObj.data.length}"
							   on-pointer-over="toHover = true" on-pointer-out="toHover = false">
								<i ng-class="{
									symbol_arrowTo_tiny_flat_black: !toHover || (goToLocation.index == goToLocation.searchObj.data.length),
									symbol_arrowTo_tiny_flat_green: toHover && (goToLocation.index != goToLocation.searchObj.data.length)
								}"></i>
							</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="overlayMarkers" class="zoomLevel{{zoomLevel+1}}">
		<div class="villageName unselectable" ng-if="zoomLevel < 2" ng-style="v.style" ng-class="{robber: v.type > 0}" ng-repeat="(id, v) in villageNames track by id" id="villageName{{id}}">
			<div class="content">
				<span class="inner jsVillageType{{v.type}}">{{v.name}}</span>
			</div>
		</div>
		<div class="mainVillage unselectable" ng-style="style" ng-repeat="(id, style) in mainVillages track by id" id="mainVillage{{id}}">
			<i class="village_main_small_flat_black"></i>
		</div>
		<div class="cropMarker unselectable cropAmount{{obj.amount}}" ng-style="obj.style" ng-repeat="(id, obj) in cropFields track by id" id="cropField{{id}}">
		</div>
		<div class="movementSprite unselectable" ng-style="obj.style" ng-repeat="(id, obj) in troopMovementSprite track by id" id="troopMovementSprite{{id}}">
			<i ng-repeat="movementType in obj.movements" class="{{movementType}}"></i>
		</div>
		<div class="fieldMarker unselectable" ng-if="zoomLevel == 0 && obj.markers.length > 0" ng-style="obj.style" ng-repeat="(id, obj) in fieldMarkers track by id" id="fieldMarker{{id}}"
			 ng-class="{'hasNavigation': obj.markers.length > 1, 'minimizedMarker': obj.minimized, 'allianceWide': obj.markers[obj.selectedMarker].data.allianceId > 0, 'personal': obj.markers[obj.selectedMarker].data.allianceId == 0 && obj.markers[obj.selectedMarker].data.isGlobal == 0}">
			<div ng-if="obj.minimized" class="wrapper" clickable="fieldMarkerToggle(obj);">
				<div class="content">
					<i class="symbol_exclamationMark_tiny_flat_black"></i>
				</div>
			</div>
			<div ng-if="!obj.minimized" class="wrapper fieldMarkerBox">
				<i class="closeNotification"
				   ng-class="{action_cancel_tiny_flat_black: !closeHover, action_cancel_tiny_flat_red: closeHover}"
				   on-pointer-over="closeHover = true" on-pointer-out="closeHover = false"
				   tooltip tooltip-translate="Notification.Delete"
				   clickable="fieldMarkerDelete(fieldMarkers, id);">
				</i>
				<div class="content" clickable="fieldMarkerToggle(obj);">
					<span ng-if="obj.markers[obj.selectedMarker].data.isGlobal == 1"
						  translate data="timeAgo:{{obj.markers[obj.selectedMarker].timeAgo}},playerId:{{obj.markers[obj.selectedMarker].data.textPlayerId}},cellId:{{obj.markers[obj.selectedMarker].data.relocateCellId}}"
						  options="{{obj.markers[obj.selectedMarker].data.text}}"
						  class="global">?</span>
					<span ng-if="obj.markers[obj.selectedMarker].data.isGlobal == 0" class="personal">
						<div class="playerBox" clickable="openPlayerWindow({{obj.markers[obj.selectedMarker].data.creatorPlayerId}})">
							<avatar-image class="playerAvatar" scale="0.5" player-id="{{obj.markers[obj.selectedMarker].data.creatorPlayerId}}"></avatar-image>
						</div>
						<div class="prestigeStars" ng-if="config.balancing.features.prestige">
							<prestige-stars playerId="{{obj.markers[obj.selectedMarker].data.creatorPlayerId}}" size="tiny"></prestige-stars>
						</div>
						<span player-link playerId="{{obj.markers[obj.selectedMarker].data.creatorPlayerId}}" nolink="true"></span>
						{{obj.markers[obj.selectedMarker].data.text}}<br>
						<span>{{obj.markers[obj.selectedMarker].timeAgo}}</span>
					</span>
				</div>
				<div class="pagination" ng-if="obj.markers.length > 1">
					<i class="symbol_arrowFrom_tiny_flat_black" clickable="fieldMarkerSwitch(obj, -1);"></i>
					{{0|bidiRatio:obj.selectedMarker+1:obj.markers.length}}
					<i class="symbol_arrowTo_tiny_flat_black" clickable="fieldMarkerSwitch(obj, 1);"></i>
				</div>
			</div>
		</div>
		<div class="clouds" id="tutorialClouds" ng-if="player.data.spawnedOnMap == 0">
			<div class="extraCover side1 tutorial_mapOverlayStart_illustration" ng-class="{invisible: player.data.villages.length > 0}"></div>
			<div class="extraCover side2 tutorial_mapOverlayEnd_illustration" ng-class="{invisible: player.data.villages.length > 0}"></div>
		</div>
	</div>

	<div id="tileInformation" class="contentBox unselectable" id="tileInformationPosition" ng-style="tiStyle" ng-class="{coordsOnly: tiInfos.coordsOnly}">
		<div class="contentBoxHeader">
			<span class="coordinates"><div coordinates nolink="true" aligned="false" x="{{tiInfos.coords.x}}" y="{{tiInfos.coords.y}}"></div></span>
			<span class="villageName truncated">{{tiInfos.villageName}}</span>
			<div class="additionalInfo iconValueList">
				<div ng-show="tiInfos.population">
					<span><i class="unit_population_small_illu"></i>{{tiInfos.population}}</span>
				</div>
				<div ng-show="tiInfos.oasisBonus">
                	<span ng-repeat="(resType, bonus) in tiInfos.oasisBonus track by resType">
                		<i class="unit_{{resType}}_small_illu"></i>{{bonus| bidiNumber:'percent':false:false}}
                	</span>
				</div>
			</div>
			<span class="mainVillageIndicator" ng-if="tiInfos.isMainVillage">
				<i class="village_main_small_flat_black"></i>
			</span>
		</div>
		<div class="contentBoxBody resources unselectable" ng-if="zoomLevel != 2 && (tiInfos.resDistribution || tiInfos.robberVillageDetails || tiInfos.oasis || tiInfos.playerName)">
			<span ng-if="tiInfos.resDistribution">
				<i class="unit_wood_small_illu"></i>{{tiInfos.resDistribution.wood}}
				<i class="unit_clay_small_illu"></i>{{tiInfos.resDistribution.clay}}
				<i class="unit_iron_small_illu"></i>{{tiInfos.resDistribution.iron}}
				<i class="unit_crop_small_illu"></i>{{tiInfos.resDistribution.crop}}
			</span>
			<span ng-if="tiInfos.oasisDetails && tiInfos.oasis.oasisStatus == Village.OASIS_STATUS_WILD">
				<span class="unit" ng-repeat="animal in tiInfos.oasisDetails.filteredTroops">
					<span unit-icon data="4, {{animal.nr}}"></span>{{animal.amount}}&nbsp;
				</span>
			</span>

			<span ng-if="tiInfos.robberVillageDetails">
				<span class="unit" ng-repeat="troop in tiInfos.robberVillageDetails.filteredTroops">
					<span unit-icon data="{{tiInfos.robberVillageDetails.data.tribeId}}, {{troop.nr}}"></span>{{troop.amount}}&nbsp;
				</span>
			</span>

			<span class="owner">
				<span ng-if="tiInfos.oasis && tiInfos.oasis.oasisStatus == Village.OASIS_STATUS_OCCUPIED">
					<i class="community_kingdom_small_flat_black"></i>
					<span player-link class="disabled" playerId="{{tiInfos.oasis.kingdomId}}" playerName=""></span>
				</span>
				<span ng-if="tiInfos.playerName">
					<span class="truncated">{{tiInfos.playerName}}</span>
					<span ng-if="tiInfos.inactive" translate>Player.Map.Inactive</span>
				</span>
				<span ng-if="tiInfos.allianceTag">
					({{tiInfos.allianceTag}})
				</span>
			</span>

			<div class="influenceBox" ng-if="tiInfos.influence">
				<i class="unit_influence_small_flat_black"></i>{{tiInfos.influence | bidiNumber:'percent':false:false}}
			</div>
		</div>
		<div class="reportsContainer unselectable" ng-if="tiInfos.report">
			<div class="reportsDecoration unselectable">
				<span class="inner">
					<i class="reportIcon reportIcon{{tiInfos.report.notificationType}}"></i>
					<span i18ndt="{{tiInfos.report.time}}" format="veryShort"></span>
					<span ng-if="tiInfos.report && tiInfos.report.capacity > 0" class="carry">
						<i ng-class="{
							unit_capacityEmpty_small_flat_black: tiInfos.report.raidedResSum == 0,
							unit_capacityHalf_small_flat_black: tiInfos.report.raidedResSum > 0 && tiInfos.report.raidedResSum < tiInfos.report.capacity,
							unit_capacity_small_flat_black: tiInfos.report.raidedResSum == tiInfos.report.capacity
				   		}"></i>
						{{tiInfos.report.raidedResSum | bidiRatio:tiInfos.report.raidedResSum:tiInfos.report.capacity}}
					</span>
				</span>
			</div>
		</div>
	</div>
	<div class="infoMovements unselectable" ng-style="tiStyle">
		<ul class="troopMovements" ng-if="zoomLevel != 2">
			<li class="small infoMovementType incoming unselectable {{info.group}}" ng-repeat="(type, info) in tiInfos.movements">
				<i class="{{info.icon}}"></i>

				<div class="countdown" countdown="{{info.first}}"></div>
				<div class="count">{{info.cnt}}</div>
				<div class="ending">
					<div class="colored"></div>
				</div>
			</li>
		</ul>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/resources.html"><div ng-controller="villageViewCtrl" ng-init="setCurrentView('resources')" class="resources viewBackground" touch-tooltips zoom min-height="800" min-width="1174" offset-height="20" org-width="1920" org-height="1440">
	<div class="resDistribution resources{{resDistribution}}"></div>
	<div class="waterOverlay" ng-if="isTown"></div>
	<div id="villageViewRes" class="villageView">
		<building-location ng-repeat="building in myBuildings.data" class="buildingLocation buildingLocation{{building.data.locationId}}"></building-location>

		<div id="smallVillageView" class="clickable" clickable="openPage('village')">
			<building-location no-status="true" ng-repeat="building in villageBuildings.data"></building-location>
		</div>

		<map ng-if="!enableSvgHighlighting" id="clickareasResources" name="clickareasResources" ng-show="areas.resources.length > 0">
			<area
				ng-repeat="a in areas.resources"
                location-id="{{ a.locationId }}"
				on-pointer-over="highlightStart({{a.locationId}})"
				on-pointer-out="highlightStop({{a.locationId}})"
				clickable="openBuildingDialog({{ a.locationId }})" tg-coords="{{a.coords}}" coords="0,0,1,1,2,2,0,1" shape="poly" building-positioner="{{a.locationId}}">
		</map>
		<img ng-if="!enableSvgHighlighting" ng-show="areas.resources.length > 0" class="clickareas" src="layout/images/x.gif" usemap="#clickareasResources">

	</div>
</div></script>
<script type="text/ng-template" id="tpl/village.html"><div ng-controller="villageViewCtrl" ng-init="setCurrentView('village')" class="village viewBackground" touch-tooltips ng-class="{'village-water': isTown}" zoom min-height="950" min-width="1174" offset-height="40" org-width="1920" org-height="1440">
	<div id="villageView" class="villageView" ng-class="{wwVillage: isWWVillage}">
		<building-location ng-repeat="building in myBuildings.data" class="buildingLocation buildingLocation{{building.data.locationId}}"
			ng-class="{free: building.data.buildingType == 0}"></building-location>
		<map ng-if="!enableSvgHighlighting" id="clickareasVillage" name="clickareasVillage" ng-show="areas.village.length > 0">
			<area
				ng-repeat="a in areas.village"
				location-id="{{ a.locationId }}"
				on-pointer-over="highlightStart({{a.locationId}})"
				on-pointer-out="highlightStop({{a.locationId}})"
				clickable="openBuildingDialog({{ a.locationId }})" tg-coords="{{a.coords}}" coords="0,0,1,1,2,2,0,1" shape="poly" building-positioner="{{a.locationId}}">
		</map>
		<img ng-if="!enableSvgHighlighting" ng-show="areas.village.length > 0" class="clickareas" src="layout/images/x.gif" usemap="#clickareasVillage">

		<div class="villageQuestGivers" ng-if="isMain">
			<quest-giver ng-repeat="questGiver in questGivers.data" data="questGiver.data"></quest-giver>
		</div>
		<img src="layout/images/x.gif" class="premiumLocationBackground state{{premiumLocations}}">
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/achievementNotifications/achievementNotifications.html"><div class="achievementNotification" ng-controller="achievementNotificationsCtrl">
	<div class="backgroundFlare rotate">
		<div class="flareRay" ng-repeat="n in []|range:0:10"></div>
	</div>
	<div class="wrapper">
		<div class="backgroundTop achievement_scrollTop_layout modalDecoration">
			<i clickable="close()" class="close action_cancel_small_flat_black"></i>
		</div>
		<div class="backgroundMiddle modalContent" scrollable height-dependency="max">
			<b translate>Achievements.AchievementsCompleted</b>

			<div class="divider"></div>
			<div class="clear"></div>
			<div ng-repeat="notification in achievementNotifications" class="achievement">
				<div class="achievementIconWrapper">
					<i class="achievements_frame{{notification.special ? 'Mystery' : notification.level}}_huge_illu achievementFrame"></i>
					<i ng-if="notification.level > 0 || notification.special" class="achievements_type{{::notification.key}}_large_illu achievementIcon"></i>
				</div>
				<div class="contentBoxHeader headerWithArrowEndings glorious gold">
					<div class="content">
						<b>{{notification.reward|bidiNumber:'':true}}</b>
						<i class="feature_prestige_small_flat_black"></i>
					</div>
				</div>
				<span class="achievementName" translate
					  data="serverName:{{::notification.extraData.serverName}},
					 	allianceTag:{{::notification.extraData.allianceTag}},
					 	allianceRank:{{::notification.extraData.allianceRank}}"
					  options="{{::notification.key}},{{::notification.langKeySuffix}}"
				>Achievements.Title_??</span>
				<div class="clear"></div>
				<span class="achievementDescription" translate
					  data="x:{{::notification.lastAchievedValue}},
					    serverName:{{::notification.extraData.serverName}},
					 	allianceTag:{{::notification.extraData.allianceTag}},
					 	allianceRank:{{::notification.extraData.allianceRank}}"
					  options="{{::notification.key}},{{::notification.langKeySuffix}}"
				>Achievements.Description_??</span>
				<div class="divider"></div>
			</div>

			<button clickable="collectRewards()" class="collectRewardsButton">
				<span translate>Achievements.CollectRewards</span>
				<i class="action_leave_small_flat_white"></i>
			</button>
		</div>
		<div class="achievement_scrollBottom_layout"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/activation/activation.html"><div id="ingameRegistration" ng-controller="activationCtrl">
	<div class="full" ng-if="useMellon">
		<mellon-frame url="{{activationIframe}}" additional-class="activationIngame"></mellon-frame>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/activation/activationNeeded.html"><div ng-if="player.data.isActivated == 0" ng-controller="activationNeededCtrl">
	<div class="needsActivationMsg" translate>
		ActivationNeeded.FeatureDisabled
	</div>
	<div>
		<button clickable="openActivation();">
			<div class="content" translate>ActivationNeeded.ActivateAccount</div>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/alliance/alliance.html"><div ng-controller="allianceCtrl" class="alliance">
  	<div ng-include src="'tpl/society/partials/alliance/Profile.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/authError/authError.html"><div class="introductionText">
<div ng-controller="authErrorCtrl">
	<p translate>AuthError.text</p>
	<button clickable="logout()"><span translate>Logout</span></button>
</div></div>
</script>
<script type="text/ng-template" id="tpl/building/building.html"><div ng-controller="buildingIndexCtrl" class="building buildingType{{building.data.buildingType}}" ng-class="{buildingResourceProduction: building.data.buildingType <= 4}">
	<div ng-include src="pageTemplate"></div>
</div></script>
<script type="text/ng-template" id="tpl/building/academy/academy_main.html"><div class="buildingDetails academy" ng-controller="academyCtrl">
	<div ng-show="isBuildingBuild()">
		<div ng-controller="unitsResearchCtrl">
			<div ng-include src="'tpl/building/partials/lists/units.html'"></div>

			<button ng-class="{disabled: unitsResearch.data.researchQueueFull || !activeItem || !activeItem.canResearch || !enoughResources(activeItem)}"
					class="footerButton disabled"
					clickable="research(activeItem)"
					tooltip
					tooltip-translate-switch="{
						'Academy.NoAdditionalResearch': {{unitsResearch.data.researchQueueFull}},
						'Academy.NothingSelected': {{!activeItem}},
						'Academy.RequirementsNotFullfilled': {{!activeItem.canResearch}},
						'Error.NotEnoughRes': {{!enoughResources(activeItem)}}
						}">
				<span translate>Button.Research</span>
			</button>

			<npc-trader-button class="footerButton" type="unitResearch" costs="{{activeItem.costs}}"></npc-trader-button>
			<div class="iconButton premium finishNow"
				 premium-feature="{{::FinishNowFeatureName}}"
				 premium-callback-param="finishNowBuildingType:{{building.data.buildingType}}"
				 confirm-gold-usage="true"
				 tooltip tooltip-url="tpl/npcTrader/finishNowTooltip.html">
				<i class="feature_instantCompletion_small_flat_black"></i>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/constructBuilding/buildingList.html"><div class="item building" ng-show="item">
	<div class="clickableContainer"
		 clickable="carousel.setActiveItem(item)"
		 ng-class="{active: carouselActiveItem.buildingType === item.buildingType}"
		 play-on-click="{{$root.UISound.BUTTON_SQUARE_CLICK}}">
		<img class="itemImage buildingHuge buildingType{{item.buildingType}} tribeId{{player.data.tribeId}}" src="layout/images/x.gif" alt="" />
		<div class="itemHead itemDesc">
			<span translate options="{{item.buildingType}}">Building_?</span>
		</div>
		<div class="horizontalLine double"></div>
		<div class="itemBody">
			<div class="symbol_lock_medium_wrapper" ng-if="!item.buildable">
				<i class="symbol_lock_medium_flat_black"></i>
			</div>
		</div>
	</div>
</div>
<div class="item dummy" ng-show="!item"></div></script>
<script type="text/ng-template" id="tpl/building/constructBuilding/constructBuilding_main.html"><div ng-controller="constructBuildingCtrl" class="constructBuilding">
	<div class="contentBox gradient">
		<div class="contentBoxBody">
			<carousel
				carousel-template="tpl/building/constructBuilding/buildingList.html"
				carousel-items="buildings"
				carousel-active-item="activeItem"
				carousel-item-primary-key="buildingType"
				carousel-window-height="w.maxWindowBodySizeObj.max"></carousel>
			<div class="constructBuildingInfo">
				<div class="description">
					<h4 translate options="{{activeItem.buildingType}}">Building_?</h4>

					<div translate options="{{activeItem.buildingType}}" data="param:{{activeItem.descriptionParam}}">Building.Description_?</div>
				</div>
				<div class="symbol_i_medium_wrapper">
					<i class="symbol_i_medium_flat_white" clickable="openWindow('help', {'pageId': 'Buildings_' + activeItem.buildingType})"
				   tooltip tooltip-translate="ConstructBuilding.ToolTip.BuildingInfo" tooltip-placement="above"></i>
				</div>
				<building-requirement buildings="activeItem.requiredBuildings"></building-requirement>
			</div>
			<display-resources class="costsFooter"
							   resources="activeItem.upgradeCosts"
							   population="{{activeItem.upgradeSupplyUsage}}"
							   time="{{activeItem.upgradeTime}}"
							   available="storage"></display-resources>
		</div>
	</div>

	<button ng-class="{disabled: !activeItem.buildable}"
			ng-show="(enoughRes && canQueue) || !activeItem.buildable"
			clickable="build()"
			tooltip
			tooltip-translate-switch = "{'ConstructBuilding.ToolTip.DisabledDueToRequirements': {{!activeItem.buildable}}}"
			class="startConstruction">
		<span translate>Button.Build</span>
	</button>
	<button ng-class="{disabled: !masterBuilderFree}"
			ng-show="(!enoughRes || !canQueue) && activeItem.buildable"
			clickable="build()"
			tooltip
			tooltip-translate-switch = "{'ConstructBuilding.ToolTip.DisabledDueToMasterBuilderFull': {{!masterBuilderFree}}}"
			class="startConstruction masterBuilder">
		<span translate>Button.BuildWithMasterBuilder</span>
	</button>
</div>
</script>
<script type="text/ng-template" id="tpl/building/default/default_main.html"><div class="buildingDetails">
	<div ng-include src="'tpl/building/partials/buildingInformation.html'"></div>
	<br>
	<p ng-if="building.data.lvl == 0 && building.data.lvlNext > 1"><span translate>Building.NotYetUsable</span></p>
</div></script>
<script type="text/ng-template" id="tpl/building/drinkHouse/drinkHouse_main.html"><div class="buildingDetails drinkHouse" ng-controller="celebrationsStartCtrl">
	<div ng-show="isBuildingBuild()">
		<div ng-include src="'tpl/building/partials/lists/celebrations.html'"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/drinkingTrough/drinkingTrough_main.html"><div class="buildingDetails">
	<div ng-include src="'tpl/building/partials/buildingInformationEffects.html'"></div>
</div>
<div class="buildingDetails effectAtLevel contentBox gradient">
	<div class="contentBoxBody">
		<div class="atLevel" ng-class="{notReached: building.data.lvl < 10}">
			<span translate data="resource: unit_consumption_small_flat_black ng-scope">Effect.DrinkingTrough10</span>
			<br>
			<span translate data="lvl: 10">Effect.FromLevel</span>
		</div>
		<div class="atLevel" ng-class="{notReached: building.data.lvl < 15}">
			<span translate data="resource: unit_consumption_small_flat_black ng-scope">Effect.DrinkingTrough15</span>
			<br>
			<span translate data="lvl: 15">Effect.FromLevel</span>
		</div>
		<div class="atLevel" ng-class="{notReached: building.data.lvl < 20}">
			<span translate data="resource: unit_consumption_small_flat_black ng-scope">Effect.DrinkingTrough20</span>
			<br>
			<span translate data="lvl: 20">Effect.FromLevel</span>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/embassy_main.html"><div class="buildingDetails embassy" ng-controller="embassyCtrl">
    <div ng-show="isBuildingBuild()">
        <div ng-include="tabBody"></div>
    </div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/alliance/allianceFound.html"><div class="contentBox transparent name">
	<h6 class="contentBoxHeader headerColored" translate>
		Alliance.Name
	</h6>

	<div class="contentBoxBody">
		<input type="text" maxlength="20" ng-model="newAlliance.name" placeholder="{{placeHolderAllianceName}}">
	</div>
</div>

<div class="contentBox transparent tag">
	<h6 class="contentBoxHeader headerColored" translate>
		Alliance.Tag
	</h6>

	<div class="contentBoxBody">
		<input type="text" maxlength="8" ng-model="newAlliance.tag" placeholder="{{placeHolderAllianceTag}}">
	</div>
</div>

<div class="buttonFooter">
	<button
		clickable="foundAlliance()"
		ng-class="{disabled: newAlliance.tag == '' || newAlliance.name == ''}"
		tooltip
		tooltip-translate="Embassy.Communities.Alliance.NeedNameAndTag"
		tooltip-show="newAlliance.tag == '' || newAlliance.name == ''">
		<span translate>Alliance.Button.Found</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Alliance.Button.Cancel</span>
	</button>

	<div class="error">{{allianceFoundError}}</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/alliance/allianceInvitationDetails.html"><div class="inWindowPopup invitationDetails">
	<div class="inWindowPopupHeader">
		<div class="navigation">
			<a class="back"
			   clickable="backToOverview()"
			   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
				<i ng-class="{
							symbol_arrowFrom_tiny_flat_black: !fromHover,
							symbol_arrowFrom_tiny_flat_green: fromHover
						}"></i>
				<span translate>Navigation.Back</span>
			</a>
		</div>
		<i class="communityIcon community_alliance_large_illu"></i>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div class="contentBox transparent">
			<h6 class="contentBoxHeader headerColored">
				<alliance-link allianceid="{{invitation.data.groupId}}"
							   alliancename="{{invitation.data.groupName}}"></alliance-link>
				<div class="sender">
					<span translate>Alliance.Invitation.From</span>
					<span player-link playerId="{{invitation.data.invitedBy}}"
								 playerName="{{invitation.data.invitedByName}}"></span>
				</div>
			</h6>

			<div class="scrollWrapper" scrollable height-dependency="max">
				<div class="contentBoxBody">
					<div ng-if="invitation.data.customText" ng-bind-html="invitation.data.customText|toHtml" class="customText"></div>
					<span ng-if="!invitation.data.customText" translate>
						Embassy.Communities.Popup.Alliance.Invitations.NoInvitationText
					</span>
				</div>
			</div>
		</div>
		<div class="buttonFooter">
			<div class="error">{{allianceInviteError}}</div>

			<button ng-class="{disabled: !player.data.isKing || player.data.allianceId > 0 || allianceReachedKingLimit}"
					clickable="acceptInvitation();"
					tooltip
					tooltip-translate-switch="{
						'Embassy.Communities.Alliance.HaveToBeKingToAccept': {{!player.data.isKing}},
						'Alliance.Invitation.PlayerInAlliance': {{player.data.allianceId > 0}},
						}"
					ng-if="!isSitter">
				<span translate>Button.Accept</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Button.Accept</span>
			</button>
			<button ng-if="!isSitter" class="cancel" clickable="declineInvitation();"><span translate>Button.Decline</span></button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/alliance/allianceInvitationOverview.html"><div class="invitationOverview" scrollable>
	<div class="clickableContainer invitationSummary"
		 ng-repeat="invitation in invitations.data"
		 clickable="openOverlay('allianceInvitation', {invitation: invitation.data.id})">
			<i class="invitationIcon"></i>
			<div class="sender">
				<div class="header truncated">
					<span translate>Embassy.Communities.Popup.Alliance.Invitations.From</span>&nbsp;{{invitation.data.invitedByName}}
				</div>
				<span class="date" i18ndt="{{invitation.data.invitationTime}}" format="shortDate"></span>
			</div>
			<div class="verticalLine double"></div>
			<div class="subject">
				<span translate class="header">Embassy.Communities.Popup.Alliance.Invitations.ToAlliance</span><br>
				{{invitation.data.groupName}}
			</div>
			<i class="decorationIcon community_alliance_large_illu"></i>
			<div class="verticalLine double"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/alliance/allianceLeave.html"><p translate data="victoryPoints:{{playerVictoryPoints}},lostVictoryPoints:{{playerVictoryPointsLost}}">Alliance.Diplomacy.LeaveVictoryPointsInfo</p>

<!-- without mellon -->
<div ng-if="!useMellon">
	<div class="contentBox transparent">
		<h6 class="contentBoxHeader headerColored" translate>Embassy.Communities.Popup.Alliance.ConfirmWithPassword</h6>
		<div class="contentBoxBody">
			<input type="password" ng-model="password.check" placeholder="Password">
		</div>
	</div>

	<div class="buttonFooter">
		<div class="error">{{allianceLeaveError}}</div>

		<button clickable="confirmLeaveAlliance()"><span translate>Button.Alliance.Leave.Confirm</span></button>
		<button clickable="closeOverlay();" class="cancel"><span translate>Alliance.Button.Cancel</span></button>
	</div>
</div>

<!-- with mellon -->
<div ng-if="useMellon">
	<div class="buttonFooter">
		<div class="error">{{allianceLeaveError}}</div>
		<button clickable="confirmWithPassword();"><span translate>Button.Alliance.Leave.Confirm</span></button>
		<button clickable="closeOverlay();" class="cancel"><span translate>Alliance.Button.Cancel</span></button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/kingdom/AbdicateConfirmation.html"><span translate>Embassy.Communities.Popup.AbdicateConfirmationDescription</span> {{coronationDuration}}h
<div translate ng-if="currentPlayer.data.hasNoobProtection">Embassy.Communities.Popup.AbdicateConfirmationNoobProtection</div>
<div class="buttonFooter">
	<button clickable="confirmAbdicate();" ng-class="{disabled: currentPlayer.data.hasNoobProtection}"><span translate>Embassy.Communities.Kingdom.Button.abdicate</span></button>
	<button clickable="closeOverlay();" class="cancel"><span translate>Button.Cancel</span></button>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/kingdom/AbdicateDukeConfirmation.html"><div class="contentWrapper">
	<i class="decorationIcon community_kingdom_large_illu"></i>
	<div class="verticalLine double"></div>
	<span translate class="text" ng-if="dukePlayerId == -1">Embassy.Communities.Popup.Duke.AbdicateConfirmationDescription</span>
	<span translate class="text" ng-if="dukePlayerId != -1">Embassy.Communities.Popup.Duke.DismissConfirmationDescription</span>
</div>
<div class="buttonFooter">
	<button clickable="confirmAbdicate();">
		<span translate ng-if="dukePlayerId == -1">Embassy.Communities.Kingdom.Button.abdicate</span>
		<span translate ng-if="dukePlayerId != -1">Embassy.Communities.Kingdom.Button.Dismiss</span>
	</button>
	<button clickable="closeOverlay();" class="cancel"><span translate>Button.Cancel</span></button>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/kingdom/NoobProtectionConfirmation.html"><span translate>Embassy.Communities.Popup.NoobProtectionWarningDescription</span>

<div class="buttonFooter">
	<button clickable="confirmBecomeKing();" class="jsConfirmButtonCoronation">
		<span translate>Button.Found</span>
	</button>
	<button clickable="closeOverlay();" class="cancel jsCancelButtonCoronation">
		<span translate>Button.Cancel</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/kingdom/foundKingdomConfirmation.html"><div>
	<p><span translate>Embassy.Communities.Popup.FoundKingdomConfirmation.Description</span></p>
</div>
<div ng-if="amountStolenGoods > 0">
	<p><span translate data="amount:{{amountStolenGoods}}">Embassy.Communities.Popup.FoundKingdomConfirmation.StolenGoodsTransform</span></p>
</div>
<div ng-if="coronationDuration > 0">
	<p><span translate data="time:{{coronationDuration}}">Embassy.Communities.Popup.FoundKingdomConfirmation.CoronationTime</span></p>
</div>
<div ng-if="currentPlayer.data.hasNoobProtection">
	<p>
		<span translate ng-if="remainingNoobProtection <= 0">Embassy.Communities.Popup.FoundKingdomConfirmation.LooseNoobProtection</span>
		<span ng-if="remainingNoobProtection > 0">
			<span translate>Embassy.Communities.Popup.FoundKingdomConfirmation.ShortenedNoobProtection</span>
			<span countdown="{{remainingNoobProtection}}"></span>
		</span>
	</p>
</div>
<div class="error" ng-if="kingError">{{kingError}}</div>
<div class="buttonFooter">
	<button clickable="confirmBecomeKing();">
		<span translate>Embassy.Communities.Kingdom.Button.foundKingdom</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Cancel</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/kingdom/kingdomInvitationDetails.html"><div class="inWindowPopup invitationDetails">
	<div class="inWindowPopupHeader">
		<div class="navigation">
			<a class="back"
			   clickable="backToOverview()"
			   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
				<i ng-class="{
							symbol_arrowFrom_tiny_flat_black: !fromHover,
							symbol_arrowFrom_tiny_flat_green: fromHover
						}"></i>
				<span translate>Navigation.Back</span>
			</a>
		</div>
		<i class="communityIcon community_kingdom_large_illu"></i>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div class="contentBox transparent">
			<h6 class="contentBoxHeader headerColored">
				<span player-link playerId="{{invitation.data.groupId}}"
							 playerName="{{invitation.data.groupName}}" ng-show="invitation.data.invitedAs==Player.KINGDOM_ROLE_GOVERNOR"></span>
				<span translate ng-if="invitation.data.invitedAs==Player.KINGDOM_ROLE_DUKE">Embassy.Communities.Popup.Kingdom.Invitations.Duke.Title</span>
				<div class="sender">
					<span translate>Alliance.Invitation.From</span>
					<span player-link playerId="{{invitation.data.invitedBy}}"
								 playerName="{{invitation.data.invitedByName}}"></span>
				</div>
			</h6>
			<div class="contentBoxBody">
				<span translate data="playerId:{{invitation.data.groupId}},playerName:{{invitation.data.groupName}}" ng-if="invitation.data.invitedAs==Player.KINGDOM_ROLE_GOVERNOR">
					Embassy.Communities.Popup.Kingdom.Invitations.InvitationText
				</span>
				<span translate data="playerId:{{invitation.data.groupId}},playerName:{{invitation.data.groupName}}"  ng-if="invitation.data.invitedAs==Player.KINGDOM_ROLE_DUKE">
					Embassy.Communities.Popup.Kingdom.Invitations.Duke.InvitationText
				</span>
			</div>
			<h6 class="contentBoxHeader headerColored" ng-if="invitation.data.customText!=''" translate>
				Society.Invite.CustomText
			</h6>
			<div class="contentBoxBody customText" ng-if="invitation.data.customText!=''">
				{{invitation.data.customText}}
			</div>
		</div>
		<div class="buttonFooter">
			<div class="error">{{kingdomInviteError}}</div>
			<button ng-if="!player.data.isKing"
					clickable="acceptInvitation();">
				<span translate>Button.Accept</span>
			</button>

			<button class="cancel" clickable="declineInvitation();"><span translate>Button.Decline</span></button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/kingdom/kingdomInvitationOverview.html"><div class="invitationOverview" scrollable>
	<div class="clickableContainer invitationSummary"
		 ng-repeat="invitation in invitations.data"
		 clickable="openOverlay('kingdomInvitation', {invitation: invitation.data.id})">
		<i class="community_invitation_small_illu"></i>
		<div class="sender">
			<div class="header truncated">
				<span translate>Embassy.Communities.Popup.Alliance.Invitations.From</span>&nbsp;{{invitation.data.invitedByName}}
			</div><br/>
			<span class="date" i18ndt="{{invitation.data.invitationTime}}" format="shortDate"></span>
		</div>
		<div class="verticalLine double"></div>
		<div class="subject" ng-if="invitation.data.invitedAs==Player.KINGDOM_ROLE_GOVERNOR">
			<span translate class="header">Society.Invitation.ToSociety</span><br>
			<span translate data="playerName: {{invitation.data.invitedByName}}">Society.Invitation.KingdomOf</span>
		</div>
		<div class="subject" ng-if="invitation.data.invitedAs==Player.KINGDOM_ROLE_DUKE">
			<span translate class="header">Society.Invitation.promoteDuke</span>
		</div>
		<i class="decorationIcon community_kingdom_large_illu"></i>
		<div class="verticalLine double"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/secretSociety/secretSocietyDissolve.html"><span translate>Society.Close.Confirm</span>

<div class="buttonFooter">
	<button clickable="confirmCloseSociety();">
		<span translate>Society.Close.Button.Confirm</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Abort</span>
	</button>
	<div class="error">{{societyCloseError}}</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/secretSociety/secretSocietyFound.html"><div class="contentBox transparent attitude">
	<h6 class="contentBoxHeader headerColored" translate>
		Embassy.Communities.Popup.SecretSociety.Create.Title.Attitude
	</h6>
	<div class="contentBoxBody">
		<div class="white">
			<label>
				<input type="radio"
					   ng-model="input.chosenAttitude"
					   ng-value="{{attitude.white}}"
					   clickable="processAttitudeChange();">
				<span translate>Embassy.Communities.Popup.SecretSociety.Create.Attitude.White</span>
			</label>
		</div>
		<div class="verticalLine"></div>
		<div class="dark">
			<label>
				<input type="radio"
					   ng-model="input.chosenAttitude"
					   ng-value="{{attitude.black}}"
					   clickable="processAttitudeChange();">
				<span translate>Embassy.Communities.Popup.SecretSociety.Create.Attitude.Black</span>
			</label>
		</div>
	</div>
</div>

<div class="contentBox transparent name">
	<div class="contentBoxHeader headerColored" translate>
		Embassy.Communities.Popup.SecretSociety.Create.Title.Name
	</div>
	<div class="contentBoxBody">
		<input maxlength="15"
			   type="text"
			   ng-model="input.name"
			   placeholder="{{placeHolderSocietyName}}" />
	</div>
</div>

<div class="contentBox transparent task"
	 ng-class="{noTarget: targetDropdown.selected == 5}">
	<div class="contentBoxHeader headerColored" translate>
		Embassy.Communities.Popup.SecretSociety.Create.Title.Task
	</div>
	<div class="contentBoxBody">
		<span tooltip
			  tooltip-translate="Society.Target.FirstChooseAttitude"
			  tooltip-show="{{targetDropdown.disabled}}">
			<div dropdown data="targetDropdown"></div>
		</span>
	</div>
</div>

<div class="contentBox transparent target"
	 ng-if="targetDropdown.selected != 5">
	<div class="contentBoxHeader headerColored" translate>
		Embassy.Communities.Popup.SecretSociety.Create.Title.Target
	</div>
	<div class="contentBoxBody">
		<serverautocomplete disabled-input="{{!targetDropdown.selected}}" autocompletedata="{{serverAutocompleteName}}" autocompletecb="{{autocompleteCallback}}" ng-model="input.targetName"></serverautocomplete>
	</div>

</div>

<div class="contentBox transparent requirement"
	 ng-if="targetDropdown.selected != 5">
	<div class="contentBoxHeader headerColored">
		<span translate>Embassy.Communities.Popup.SecretSociety.Create.Title.Condition</span>
		<span class="optional">(<span translate>Optional</span>)</span>
	</div>
	<div class="contentBoxBody">
		<span tooltip
			  tooltip-translate="Society.Target.FirstChooseAttitude"
			  tooltip-show="{{targetDropdown.disabled}}">
			<div dropdown data="conditionDropdown"></div>
		</span>
	</div>
</div>

<div class="contentBox transparent value"
	 ng-if="targetDropdown.selected != 5">
	<div class="contentBoxHeader headerColored" translate>
		Embassy.Communities.Popup.SecretSociety.Create.Title.Value
	</div>
	<div class="contentBoxBody">
		<input ng-disabled="!conditionDropdown.selected"
			   number
			   maxlength="5"
			   ng-model="input.conditionValue"
			   placeholder="{{valuePlaceholder}}" />
	</div>
</div>

<div class="contentBox transparent sharedInformation">
	<div class="contentBoxHeader headerColored">
		<span translate>Embassy.Communities.Popup.SecretSociety.Create.Title.SharedInformation</span>
		<span class="optional">(<span translate>Optional</span>)</span>
	</div>
	<div class="contentBoxBody">
		<label>
			<input type="checkbox" ng-model="shared.reports">
			<span translate>Society.SharedInformation.Reports</span>
		</label>
		<label>
			<input type="checkbox" ng-model="shared.nextAttacks">
			<span translate>Society.SharedInformation.NextAttacks</span>
		</label>
		<label>
			<input type="checkbox" ng-model="shared.villageDetails">
			<span translate>Society.SharedInformation.VillageDetails</span>
			<span translate class="additional">Society.SharedInformation.VillageDetails.Additional</span>
		</label>
	</div>
</div>

<div class="buttonFooter">
	<button clickable="foundNew();"
			ng-class="{disabled: !checkValid()}"
			tooltip
			tooltip-translate="Society.Found.MissingInformation"
			tooltip-show="{{!checkValid()}}">
		<span translate>Society.FoundNew</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Cancel</span>
	</button>

	<div class="error">{{societyFoundError}}</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/secretSociety/secretSocietyInvitationDetails.html"><div class="inWindowPopup invitationDetails">
	<div class="inWindowPopupHeader">
		<div class="navigation">
			<a class="back"
			   clickable="backToOverview()"
			   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
				<i ng-class="{
						symbol_arrowFrom_tiny_flat_black: !fromHover,
						symbol_arrowFrom_tiny_flat_green: fromHover
					}"></i>
				<span translate>Navigation.Back</span>
			</a>
		</div>
		<i class="communityIcon community_secretSociety_large_illu"></i>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div class="contentBox transparent">
			<h6 class="contentBoxHeader headerColored">
				<secret-society-link societyId="{{invitation.data.groupId}}"
									 societyName="{{invitation.data.groupName}}"></secret-society-link>
				<div class="sender">
					<span translate>Society.Invitation.From</span>
					<span player-link playerId="{{invitation.data.invitedBy}}"
								 playerName="{{invitation.data.invitedByName}}"></span>
				</div>
			</h6>
			<div class="contentBoxBody">
				<div class="greeting">
					<span translate data="playerName: {{invitation.data.playerName}}">Society.Invitation.Text.HelloPlayer</span><br><br>
					<span translate options="{{society.data.attitude}}, {{society.data.targetType}}"
							   data="targetId: {{society.data.targetId}}, targetName: {{targetObj.data.name}}">
						Society.Aim_?_?
					</span>
				</div>

				<div class="condition" ng-repeat="c in conditions.data">
					<span translate options="{{c.data.type}}, {{society.data.attitude}}" data="value: {{c.data.value}}">Society.Condition_?_?</span>
				</div>

				<div class="sharedInformations" ng-if="hasSharedInformation">
					<span translate>Society.Invitation.Text.SharedInformations</span>
					<ul>
						<li ng-if="society.isShared(shared.reports);" translate>Society.SharedInformation.Reports</li>
						<li ng-if="society.isShared(shared.nextAttacks);" translate>Society.SharedInformation.NextAttacks</li>
						<li ng-if="society.isShared(shared.villageDetails);">
							<span translate>Society.SharedInformation.VillageDetails</span>
							<span translate>Society.SharedInformation.VillageDetails.Additional</span>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- custom text -->
		<div ng-if="invitation.data.customText" class="customText contentBox transparent">
			<h6 class="contentBoxHeader headerColored" translate>
				Society.Invite.CustomText
			</h6>

			<div class="scrollWrapper" scrollable>
				<div class="contentBoxBody customText" ng-bind-html="invitation.data.customText|toHtml"></div>
			</div>
		</div>

		<!-- conditions -->
		<div ng-if="hasConditions" class="conditions contentBox transparent">
			<h6 class="contentBoxHeader headerColored" translate>
				Society.Conditions
			</h6>
			<div class="contentBoxBody">
				<div ng-repeat="c in conditions.data">
					<span translate options="{{c.data.type}},{{society.data.attitude}}" data="value:{{c.data.value}}">Society.Condition_?_?</span>
					<div progressbar perc="{{c.data.ownValue/c.data.value*100}}" label="{{0 | bidiRatio:c.data.ownValue:c.data.value}}"></div>
				</div>
			</div>
		</div>
		<div class="buttonFooter">
			<div ng-if="!isSitter">
				<button clickable="acceptInvitation();"
						ng-class="{disabled: !allConditionsMet}"
						tooltip
						tooltip-translate="Error.ConditionNotMet"
						tooltip-hide="{{allConditionsMet}}">
					<span translate>Button.Accept</span>
				</button>
				<button class="cancel" clickable="declineInvitation();"><span translate>Button.Decline</span></button>
			</div>
			<div ng-if="isSitter">
				<button class="disabled"
						tooltip
						tooltip-translate="Sitter.DisabledAsSitter"
						ng-if="isSitter">
					<span translate>Button.Accept</span>
				</button>
				<button class="disabled"
						tooltip
						tooltip-translate="Sitter.DisabledAsSitter"
						ng-if="isSitter">
					<span translate>Button.Decline</span>
				</button>
			</div>
			<div class="error">{{societyInviteError}}</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/secretSociety/secretSocietyInvitationOverview.html"><div class="invitationOverview" scrollable>
	<div class="clickableContainer invitationSummary"
		 ng-repeat="invitation in invitations.data"
		 clickable="openOverlay('secretSocietyInvitation', {invitation: invitation.data.id})">
		<i class="community_invitation_small_illu"></i>
		<div class="sender">
			<div class="header truncated">
				<span translate>Society.Invitation.From</span>&nbsp;{{invitation.data.invitedByName}}
			</div>
			<span class="date" i18ndt="{{invitation.data.invitationTime}}" format="shortDate"></span>
		</div>
		<div class="verticalLine double"></div>
		<div class="subject">
			<span translate class="header">Society.Invitation.ToSociety</span><br>
			{{invitation.data.groupName}}
		</div>
		<i class="decorationIcon community_secretSociety_large_illu"></i>
		<div class="verticalLine double"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/overlay/secretSociety/secretSocietyLeave.html"><span translate>Society.Leave.Confirm</span>

<div class="buttonFooter">
	<button clickable="confirmLeaveSociety();">
		<span translate>Society.Leave.Button.Confirm</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Abort</span>
	</button>
	<div class="error">{{societyLeaveError}}</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/embassy/partials/Alliance.html"><div ng-controller="embassyAllianceCtrl" class="embassyAlliance">
	<h6 class="headerWithIcon arrowDirectionDown contentBoxHeader"
		ng-class="{availableInvitation: invitations.data.length > 0}">
		<i class="community_alliance_medium_flat_black communityIcon"></i>
		<span translate class="title">Embassy.Header.details</span>

		<a clickable="openOverlay('allianceInvitation');"
		   class="invitations"
		   ng-class="{disabled: invitations.data.length <= 0}">
			<span translate data="amount: {{invitations.data.length}}">Embassy.Communities.Alliance.Invitations</span>
			<i class="community_invitation_small_illu" ng-class="{disabled: invitations.data.length <= 0}"></i>
		</a>
	</h6>

	<div class="contentBoxBody detailsContent"
		 ng-class="{followingFooter: !alliance || allianceFounder.playerId != user.data.playerId}">

		<!-- no alliance -->
		<div ng-if="!alliance">
			<span translate>Embassy.Communities.Alliance.NoAlliance</span>
			<br>

			<!-- neither governor, nor king -->
			<span translate ng-if="!user.data.isKing && user.data.kingdomId <= 0">
				Embassy.Communities.Alliance.HowToGetAnAlliance
			</span>

			<!-- is governor -->
			<span translate ng-if="!user.data.isKing && user.data.kingdomId > 0">
				Embassy.Communities.Alliance.GovernorNoAlliance
			</span>

			<!-- is king -->
			<span translate ng-if="user.data.isKing">
				Embassy.Communities.Alliance.KingNoAlliance
			</span>
		</div>

		<!-- in alliance -->
		<div ng-if="alliance" class="membership contentBox gradient">
			<h6 class="contentBoxHeader headerWithArrowEndings" ng-class="{glorious: user.data.isKing}">
				<div class="content">
					<div class="nameAlliance truncated">{{alliance.data.name}}</div>
					<div class="founder" ng-if="allianceFounder.playerId == user.data.playerId">
						(<span translate>Embassy.Communities.Founder</span>)
					</div>
				</div>
				<i class="headerButton"
				   ng-class="{action_leave_small_flat_black: !leaveHover, action_leave_small_flat_red: leaveHover}"
				   on-pointer-over="leaveHover = true" on-pointer-out="leaveHover = false"
				   clickable="openOverlay('allianceLeave')"
				   tooltip
				   tooltip-translate="Alliance.LeaveAlliance"
				   ng-if="!isSitter && user.data.isKing">
				</i>
			</h6>

			<div class="contentBoxBody">
				<a class="showDetails" clickable="openWindow('society', {tab: 'Alliance'})">
					<i class="embassyDetails"></i>
					<span translate>Embassy.Communities.showDetails</span>
				</a>

				<div class="horizontalLine"></div>
				<span translate ng-if="user.data.isKing">Embassy.Communities.Alliance.KingGovernorDescription</span>
				<span translate ng-if="!user.data.isKing">Embassy.Communities.Alliance.MemberAsGovernor</span>
			</div>
		</div>
	</div>

	<!-- not alliance leader -->
	<div ng-if="allianceFounder.playerId != user.data.playerId"
		 class="detailsFooter contentBoxFooter">

		<!-- is not king -->
		<div class="footerContent" ng-if="!user.data.isKing">
			<span translate>Embassy.Communities.Alliance.FoundKingdomFirst</span>
			<div class="horizontalLine"></div>
			<button class="disabled"
					tooltip
					tooltip-translate="Embassy.Communities.Alliance.HaveToBeKingToFound"
					ng-if="!isSitter">
				<span translate>Embassy.Communities.Alliance.FoundAlliance</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Embassy.Communities.Alliance.FoundAlliance</span>
			</button>
		</div>

		<!-- no alliance, is king -->
		<div class="footerContent" ng-if="!alliance && user.data.isKing">
			<span translate>Embassy.Communities.Alliance.FoundAllianceInfo</span>
			<div class="horizontalLine"></div>
			<button clickable="openOverlay('allianceFound');" class="jsQuestCoronationButton"
				ng-if="!isSitter">
				<span translate>Embassy.Communities.Alliance.FoundAlliance</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Embassy.Communities.Alliance.FoundAlliance</span>
			</button>
		</div>

		<!-- in alliance, is king -->
		<div class="footerContent" ng-if="alliance && user.data.isKing">
			<span translate>Embassy.Communities.Alliance.HaveToLeaveAlliance</span>
			<div class="horizontalLine"></div>
			<button class="disabled"
					tooltip
					tooltip-translate="Embassy.Communities.Alliance.AlreadyInAlliance"
					ng-if="!isSitter">
				<span translate>Embassy.Communities.Alliance.FoundAlliance</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Embassy.Communities.Alliance.FoundAlliance</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/partials/Kingdom.html"><div ng-controller="embassyKingdomCtrl" class="embassyKingdom">
	<h6 class="headerWithIcon arrowDirectionDown contentBoxHeader">
		<i class="community_kingdom_medium_flat_black communityIcon"></i>
		<span translate class="title">Embassy.Header.details</span>

		<a clickable="openOverlay('kingdomInvitation');"
		   class="invitations"
		   ng-class="{disabled: invitations.data.length <= 0}" ng-if="coronationStatus == Player.CORONATION_STATUS.NONE">
			<span translate data="amount: {{invitations.data.length}}">Embassy.Communities.Alliance.Invitations</span>
			<i class="community_invitation_small_illu" ng-class="{disabled: invitations.data.length <= 0}"></i>
		</a>
	</h6>

	<div class="contentBoxBody detailsContent"
		 ng-class="{followingFooter: coronationStatus != Player.CORONATION_STATUS.CROWNED}">
		<!-- neither governor nor king -->
		<span translate ng-if="!myKing">Embassy.Communities.Kingdom.noKingdom</span>

		<!-- is governor or king -->
		<div ng-if="myKing" class="membership contentBox gradient">
			<h6 class="contentBoxHeader headerWithArrowEndings" ng-class="{glorious: coronationStatus == Player.CORONATION_STATUS.CROWNED}">
				<div class="content">
					<span translate class="nameKing truncated" data="name: {{myKing.data.name}}">Embassy.Communities.KingdomBanner.name</span>
				</div>
				<i ng-if="coronationStatus == Player.CORONATION_STATUS.CROWNED && !isSitter && !user.data.hasNoobProtection"
				   class="headerButton jsQuestButtonCoronation"
				   ng-class="{action_leave_small_flat_black: !leaveHover, action_leave_small_flat_red: leaveHover}"
				   on-pointer-over="leaveHover = true" on-pointer-out="leaveHover = false"
				   clickable="openOverlay('abdicateKingdom')"
				   tooltip
				   tooltip-translate="Embassy.Communities.Kingdom.Button.abdicate">
				</i>
			</h6>

			<div class="contentBoxBody">
				<a class="showDetails" clickable="openWindow('society', {tab: 'Kingdom'})">
					<i class="embassyDetails"></i>
					<span translate>Embassy.Communities.showDetails</span>
				</a>
				<div class="horizontalLine"></div>
				<span translate ng-if="coronationStatus == Player.CORONATION_STATUS.CROWNED">Embassy.Communities.kingDescription</span>
				<span translate ng-if="coronationStatus != Player.CORONATION_STATUS.CROWNED && player.data.kingdomRole == Player.KINGDOM_ROLE_DUKE" data="name: {{myKing.data.name}}">Embassy.Communities.Kingdom.DukeDescription</span>
				<span translate ng-if="coronationStatus != Player.CORONATION_STATUS.CROWNED && player.data.kingdomRole != Player.KINGDOM_ROLE_DUKE" data="name: {{myKing.data.name}}">Embassy.Communities.Kingdom.governorDescription</span>
				<div class="abdicateAsDuke" ng-if="player.data.kingdomRole == Player.KINGDOM_ROLE_DUKE">
					<div class="horizontalLine double"></div>
					<a clickable="openOverlay('abdicateDuke')"><i class="action_leave_small_flat_green"></i> <span translate>Embassy.Communities.Kingdom.abdicateAsDuke</span></a>
				</div>
			</div>
		</div>
	</div>

	<!-- not king -->
	<div ng-if="coronationStatus == Player.CORONATION_STATUS.NONE"
		 class="detailsFooter contentBoxFooter">
		<div class="footerContent">
			<span translate ng-if="player.data.kingdomRole != Player.KINGDOM_ROLE_DUKE && !player.data.hasNoobProtection">Embassy.Communities.foundKingdomDescription</span>
			<span translate ng-if="player.data.kingdomRole == Player.KINGDOM_ROLE_DUKE && !player.data.hasNoobProtection">Embassy.Communities.Duke.foundKingdomDescription</span>
			<table class="infoBox transparent" ng-if="!visibleTreasuryAvailable">
				<tbody>
					<tr>
						<td><i class="symbol_warning_tiny_flat_red"></i></td>
						<td ng-if="!treasuryAvailable && !player.data.hasNoobProtection">
							<span translate>Embassy.Communities.NoTreasury</span>
							<div>
								<span translate>Embassy.Communities.NoTreasuryMoreInformation</span>
								<a clickable="openOverlay('manual', {'overlaytab': 'Buildings', 'glossarId': Building.TYPE.HIDDEN_TREASURY})" translate options="{{Building.TYPE.HIDDEN_TREASURY}}">Building_?</a>
							</div>
						</td>
						<td ng-if="treasuryAvailable && !player.data.hasNoobProtection"><span translate>Embassy.Communities.HiddenTreasury</span></td>
						<td ng-if="player.data.hasNoobProtection">
							<span translate>Embassy.Communities.StillInNoobProtection</span>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="horizontalLine"></div>

			<button class="jsQuestButtonCoronation"
					tooltip="{{becomeKingToolTip}}"
					clickable="openOverlay('foundKingdom')"
					ng-if="!isSitter"
					ng-class="{disabled: !treasuryAvailable || player.data.hasNoobProtection}">
				<span translate>Embassy.Communities.Kingdom.Button.foundKingdom</span>
			</button>
			<button class="jsQuestButtonCoronation disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Embassy.Communities.Kingdom.Button.foundKingdom</span>
			</button>
		</div>
	</div>

	<!-- running coronation -->
	<div ng-if="coronationStatus == Player.CORONATION_STATUS.IN_CEREMONY"
		 class="detailsFooter contentBoxFooter">
		<div class="footerContent">
			<span translate data="time: {{user.data.kingstatus}}">Embassy.Communities.Kingdom.FinishTime</span>

			<div class="horizontalLine"></div>

			<button clickable="cancelBecomeKing()" ng-if="!isSitter" class="cancel">
				<span translate>Embassy.Communities.Kingdom.AbortCoronation</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Embassy.Communities.Kingdom.AbortCoronation</span>
			</button>
		</div>
	</div>
</div>

<div class="error" ng-if="kingError">{{kingError}}</div>
</script>
<script type="text/ng-template" id="tpl/building/embassy/partials/SecretSociety.html"><div class="embassySecretSociety" ng-controller="embassySecretSocietyCtrl">
	<h6 class="headerWithIcon arrowDirectionDown contentBoxHeader"
		ng-class="{availableInvitation: invitations.data.length > 0}">
		<i class="community_secretSociety_medium_flat_black communityIcon"></i>
		<span translate class="title">Embassy.Header.details</span>

		<a clickable="openOverlay('secretSocietyInvitation');"
		   class="invitations"
		   ng-class="{disabled: invitations.data.length <= 0}">
			<span translate data="amount: {{invitations.data.length}}">Embassy.Communities.SecretSociety.Invitations</span>
			<i class="community_invitation_small_illu" ng-class="{disabled: invitations.data.length <= 0}"></i>
		</a>
	</h6>

	<div class="contentBoxBody detailsContent followingFooter">
		<div class="scrollWrapper" scrollable height-dependency="max">
			<!-- no secret society -->
			<div ng-if="societies.data.length == 0">
				<span translate>Embassy.Communities.SecretSociety.noSociety</span>
			</div>

			<!-- own secret societies -->
			<div ng-if="ownSociety"
				 class="membership contentBox gradient">

				<h6 class="contentBoxHeader headerWithArrowEndings glorious">
					<div class="content">
						<div class="name truncated">{{ownSociety.data.name}}</div>
						<div class="founder">
							(<span translate>Embassy.Communities.Founder</span>)
						</div>
					</div>
					<i class="headerButton"
					   ng-class="{action_leave_small_flat_black: !leaveHover, action_leave_small_flat_red: leaveHover}"
					   on-pointer-over="leaveHover = true" on-pointer-out="leaveHover = false"
					   clickable="openOverlay('secretSocietyDissolve', {'societyId': {{ownSociety['data']['groupId']}}})"
					   tooltip
					   tooltip-translate="Society.Close.SecretSociety" ng-if="!isSitter">
					</i>
				</h6>

				<div class="contentBoxBody">
					<a class="showDetails" clickable="openWindow('society', {tab: 'SecretSociety', 'societyId': {{ownSociety['data']['groupId']}}})">
						<i class="embassyDetails"></i>
						<span translate>Embassy.Communities.showDetails</span>
					</a>
				</div>
			</div>

			<!-- member of secret societies -->
			<div ng-repeat="society in societies.data"
				 ng-if="society.data.groupId != ownSociety.data.groupId"
				 class="membership contentBox gradient">

				<h6 class="contentBoxHeader headerWithArrowEndings">
					<div class="content">
						<div class="name truncated">{{society.data.name}}</div>
					</div>
					<i class="headerButton"
					   ng-class="{action_leave_small_flat_black: !leaveHover, action_leave_small_flat_red: leaveHover}"
					   on-pointer-over="leaveHover = true" on-pointer-out="leaveHover = false"
					   clickable="openOverlay('secretSocietyLeave', {'societyId': {{society['data']['groupId']}}})"
					   tooltip
					   tooltip-translate="Society.Leave.SecretSociety">
					</i>
				</h6>

				<div class="contentBoxBody">
					<a class="showDetails" clickable="openWindow('society', {tab: 'SecretSociety', 'societyId': {{society['data']['groupId']}}})">
						<i class="embassyDetails"></i>
						<span translate>Embassy.Communities.showDetails</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="detailsFooter contentBoxFooter">
		<!-- no own secret society -->
		<div class="footerContent" ng-if="!ownSociety">
			<span translate>Embassy.Communities.SecretSociety.foundSecretSocietyInfo</span>
			<div class="horizontalLine"></div>
			<button clickable="openOverlay('secretSocietyFound')" ng-if="!isSitter">
				<span translate>Embassy.Communities.SecretSociety.Button.Found</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Embassy.Communities.SecretSociety.Button.Found</span>
			</button>
		</div>

		<!-- has own secret society -->
		<div class="footerContent" ng-if="ownSociety">
			<span translate>Embassy.Communities.SecretSociety.alreadySecretSocietyInfo</span>
			<div class="horizontalLine"></div>
			<button class="disabled"
					tooltip
					tooltip-translate="Embassy.Communities.SecretSociety.cannotFoundSecretSocietyInfo">
				<span translate>Embassy.Communities.SecretSociety.Button.Found</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/subtabs/CommunitiesNavigation.html"><nav class="tabulation {{tabData.tabName}} {{tabData.tabType}}" ng-if="tabData.tabs.length > 1">
	<a class="tab clickableContainer"
	   clickable="selectTab('{{tab}}')"
	   ng-repeat="tab in tabData.tabs"
	   ng-class="{active: tab == tabData.currentTab}"
	   play-on-click="{{UISound.BUTTON_SQUARE_CLICK}}">
		<h4 translate options="Society.Headline.{{tab}}">?</h4>
		<div class="horizontalLine double"></div>
		<i ng-class="{
			community_kingdom_huge_illu: tab == 'Kingdom',
			community_alliance_huge_illu: tab == 'Alliance',
			community_secretSociety_huge_illu: tab == 'SecretSociety'
		}"></i>
		<i class="arrow" ng-show="tab == tabData.currentTab"></i>
	</a>
</nav>
<div class="tabContent contentBox">
	<div ng-transclude></div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/tabs/Communities.html"><div class="communities" ng-controller="embassyCommunitiesCtrl">
	<div tabulation tab-config-name="embassyCommunitiesTabConfig" template-url="tpl/building/embassy/subtabs/CommunitiesNavigation.html">
		<div ng-include="tabBody_subtab"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/tabs/Oases.html"><div class="embassyArea" ng-controller="embassyOasesCtrl">
	<div class="contentBox gradient oasisSlots">
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content" translate>
				Embassy.Oasis.OasisSlots
			</div>
		</div>
		<div class="contentBoxBody">
			<div ng-repeat="oasis in oases"
				 class="arrowContainer arrowDirectionTo"
				 ng-class="{disabled: building.data.lvl < oasis.lvl, locked: building.data.lvl < oasis.lvl, active: building.data.lvl >= oasis.lvl}"
				 on-pointer-over="oasis.hover = true"
				 on-pointer-out="oasis.hover = false">
				<span class="arrowInside">{{$index + 1}}</span>
				<span class="arrowOutside">
					<div class="contentWrapper" ng-if="oasis.used != null">
						<span translate>Oasis</span>
						<div coordinates aligned="true" x="{{oasis.used.data.coordsX}}" y="{{oasis.used.data.coordsY}}"></div>
						<div class="resourceBonus">
							<display-resources resources="oasis.used.data.bonus" hide-zero="true" percent="true"></display-resources>
						</div>
						<div class="delete" ng-show="oasis.hover">
							<i class="delete"
							   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
							   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
							   clickable="clearOasis({{oasis.used.data.oasisId}},{{oasis.used.data.usedByVillage}})"
							   tooltip tooltip-translate="Embassy.ClearOasis"></i>
						</div>
					</div>
					<div ng-if="oasis.used == null">
						<div ng-if="building.data.lvl >= oasis.lvl">
							<span translate>Embassy.Oasis.Available</span>
							<div dropdown data="oasis.dropdown">
								<div coordinates class="coordinates" aligned="true" x="{{option.coordsX}}" y="{{option.coordsY}}"></div>
								<display-resources resources="option.bonus" hide-zero="true" percent="true"></display-resources>
							</div>
						</div>
						<div class="lockedSlot" ng-if="building.data.lvl < oasis.lvl">
							<span translate data="lvl: {{oasis.lvl}}">Embassy.Oasis.AvailableAt</span>
							<div class="symbol_lock_small_wrapper">
								<i class="symbol_lock_small_flat_black"></i>
							</div>
						</div>
					</div>
				</span>
			</div>
		</div>
	</div>
	<div class="contentBox gradient oasisInRange">
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content" translate>
				Embassy.Oasis.OasesInRange
			</div>
		</div>
		<div class="contentBoxBody">
			<table class="fixedTableHeader" scrollable>
				<thead>
					<tr>
						<th class="coordinates" translate>TableHeader.Oasis</th>
						<th class="kingdom" translate>TableHeader.Kingdom</th>
						<th class="rank"><i class="rank" tooltip tooltip-translate="Rank"></i></th>
						<th class="resources" translate>TableHeader.Bonus</th>
						<th class="village">
							<i class="village_village_small_flat_black" tooltip tooltip-translate="Embassy.Oasis.UsedByVillage"></i></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="oasis in oasesInReach" ng-class="{disabled: oasis.isWild}">
						<td class="coordinates">
							<div coordinates aligned="true" x="{{oasis.coordsX}}" y="{{oasis.coordsY}}"></div>
						</td>
						<td class="kingdom">
							<span ng-show="oasis.kingdomId == 0">-</span>
							<span ng-show="oasis.kingdomId != 0"><span player-link playerId="{{oasis.kingdomId}}" playername=""></span></span>
						</td>
						<td class="rank">
							<span ng-show="oasis.myRank == 0">-</span>
							<span ng-show="oasis.myRank > 0">{{oasis.myRank}}</span>
						</td>
						<td class="resources">
							<display-resources resources="oasis.bonus" percent="true" hide-zero="true"></display-resources>
						</td>
						<td class="village">
							<span ng-show="oasis.usedByVillage != 0">
								<span village-link villageId="{{oasis.usedByVillage}}" villageName=""></span>
							</span>
							<span ng-show="oasis.usedByVillage == 0">
								<span ng-if="!oasis.isWild" translate>Embassy.Oasis.NotAssigned</span>
								<span ng-if="oasis.isWild" translate>Embassy.Oasis.IsWild</span>
							</span>
						</td>
					</tr>
					<tr ng-if="oasesInReach.length == 0">
						<td class="noOasesInReach"><span translate>Embassy.Oases.NoOasesInReach</span></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/embassy/tooltips/DeliveryTooltip.html"><h2 translate>Embassy.Oases.Tooltip.Delivery</h2>
<div class="horizontalLine"></div>
<display-resources hide-zero="true" resources="oasis.delivery.resources"></display-resources>
</script>
<script type="text/ng-template" id="tpl/building/hiddenTreasury/hiddenTreasury_main.html"><div class="treasury buildingDetails" ng-controller="hiddenTreasuryCtrl">
	<div ng-include src="'tpl/building/partials/buildingInformation.html'"></div>
	<div class="contentBox gradient">
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content" translate>
				Building.EffectUsage_45
			</div>
		</div>
		<div class="contentBoxBody">
			<p translate>Building.StorageDescription_45</p>
			<div class="floatWrapper costs hiddenTreasuryStorage">
				<div class="resourceBig" ng-repeat="resource in ['wood', 'clay', 'iron']">
					<p><i class="unit_{{resource}}_large_illu"></i></p>
					<p class="resourceDescription">
						<span class="resource" ng-class="{notEnough: treasuryResources[$index+1] >= currentEffect.values[0]}">{{treasuryResources[$index+1] | bidiNumber:numberUnit:false:false}}</span>/{{currentEffect.values[0]}}
					</p>
				</div>
				<div class="resourceBig">
					<p class="resourceControls"></p>
					<p>
						<button clickable="claimResources()" class="button disabled"
							ng-if="treasuryResources[1] + treasuryResources[2] + treasuryResources[3] < 1"
							tooltip tooltip-translate="HiddenTreasury.TooltipClaimNotPossible">
							<span translate>Building.Claim</span>
						</button>
						<button clickable="claimResources()" class="button"
							ng-if="treasuryResources[1] + treasuryResources[2] + treasuryResources[3] >= 1"
							tooltip tooltip-translate="HiddenTreasury.TooltipClaim">
							<span translate>Building.Claim</span>
						</button>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div ng-if="currentPlayer.data.isKing || currentPlayer.data.kingdomRole == Player.KINGDOM_ROLE_DUKE" ng-show="!dataLoading" class="transform contentBox gradient">
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content">
				<span translate>Building.Reconstruct</span>
			</div>
		</div>
		<div class="contentBoxBody">
			<div class="floatWrapper" ng-show="canTransformToTreasury || transformationFinished">
				<div ng-show="!transformationFinished" class="activateInfo">
					<span translate data="usedSlots:{{slotInfo.usedSlots}},totalSlots:{{slotInfo.totalSlots}}">HiddenTreasury.TransformText</span>
				</div>
				<div ng-show="transformationFinished" class="activateInfo">
					<span translate data="duration:{{transformationFinished}}">Treasury.TransformationFinishedIn</span>
				</div>
				<div class="activateControl">
					<button class="button" clickable="transformToTreasury()" ng-class="{disabled: transformationFinished}" ng-disabled="transformationFinished" tooltip tooltip-translate="HiddenTreasury.TransformButtonActivate">
						<span translate>HiddenTreasury.ActivateButton</span>
					</button>
				</div>
			</div>
			<div class="floatWrapper cancelTransformations" ng-show="$root.currentServerTime <= abortButtonShowTime">
				<div class="activateInfo">
					<span translate data="time:{{abortButtonShowTime}}">HiddenTreasury.AbortCountdown</span>
				</div>
				<div class="cancelControl">
					<button class="button cancel" clickable="cancelTransformToTreasury()">
						<span translate>Button.Abort</span>
					</button>
				</div>
			</div>
			<div class="floatWrapper" ng-show="!canTransformToTreasury && !transformationFinished && !maxSlotsReached">
				<div class="activateInfo">
					<span translate data="usedSlots:{{slotInfo.usedSlots}},totalSlots:{{slotInfo.totalSlots}}">HiddenTreasury.TreasuryLimitReached</span>
				</div>
				<div class="activateControl">
					<button class="button disabled" tooltip tooltip-translate="HiddenTreasury.TransformButtonCurrentlyNotPossible">
						<span translate>HiddenTreasury.ActivateButton</span>
					</button>
				</div>
			</div>
			<div class="floatWrapper" ng-show="maxSlotsReached">
				<div class="activateInfo" ng-show="currentPlayer.data.isKing">
					<span translate>HiddenTreasury.TreasuryTotalLimitReached</span>
				</div>
				<div class="activateInfo" ng-show="currentPlayer.data.kingdomRole == Player.KINGDOM_ROLE_DUKE">
					<span translate>HiddenTreasury.Duke.TreasuryTotalLimitReached</span>
				</div>
				<div class="activateControl">
					<button class="button disabled" tooltip tooltip-translate="HiddenTreasury.TransformButtonCurrentlyNotPossible">
						<span translate>HiddenTreasury.ActivateButton</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div ng-if="currentPlayer.getCoronationStatus() == Player.CORONATION_STATUS.IN_CEREMONY && transformationFinished" class="contentBox gradient">
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content">
				<span translate>HiddenTreasury.Coronation</span>
			</div>
		</div>
		<div class="contentBoxBody">
			<span translate data="time: {{currentPlayer.data.kingstatus}}">Embassy.Communities.Kingdom.FinishTime</span>
			<div translate>HiddenTreasury.AfterCoronation</div>
		</div>
	</div>
	<div ng-if="!currentPlayer.data.isKing && currentPlayer.data.kingdomRole != Player.KINGDOM_ROLE_DUKE" ng-show="!dataLoading" class="transform contentBox gradient">
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content">
				<span translate>Building.Reconstruct</span>
			</div>
		</div>
		<div class="contentBoxBody">
			<div class="floatWrapper">
				<div class="activateInfo">
					<span translate>HiddenTreasury.GovernorText</span>
				</div>
				<div class="activateControl">
					<button class="button disabled" tooltip tooltip-translate="HiddenTreasury.TransformButtonNotPossible">
						<span translate>HiddenTreasury.ActivateButton</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/hideout/hideout_main.html"><div class="buildingDetails">
	<div ng-include src="'tpl/building/partials/buildingInformationEffects.html'"></div>
	<div class="buildingEffect allInVillage contentBox gradient" ng-show="crannyCount > 1" ng-controller="crannyCtrl">
		<h6 class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="empty"></i>
			<span translate>Building.allCrannies</span>
		</h6>
		<div class="contentBoxBody">
			<div class="capacity">
				<h6 class="headerTrapezoidal">
					<div class="ceveontent" translate>
						Building.Capacity
					</div>
				</h6>
				<div class="value"
					 data="value: {{wholeEffect}}"
					 options="{{building.data.buildingType}}"
					 translate>
					Building.EffectValueShort_0_?
				</div>
				<div class="unit" options="{{building.data.buildingType}}" translate>
					Building.EffectUnit_0_?
				</div>
			</div>
			<div class="lootableResources">
				<h6 class="headerTrapezoidal">
					<div class="content" translate>
						Building.LootableResources
					</div>
				</h6>
				<div class="resourceWrapper">
					<div class="resource" ng-repeat="(key, resource) in lootableResources">
						<i class="unit_{{resource.name}}_medium_illu"></i>
						<span class="lootable" ng-if="resource.value > 0">{{resource.value}}</span>
						<span ng-if="resource.value <= 0">0</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/mainBuilding/mainBuilding_main.html"><div class="buildingDetails mainBuilding" ng-controller="mainBuildingCtrl">
	<div class="editVillageName contentBox gradient">
		<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
			<i class="village_village_medium_flat_black"></i>
			<div class="content" translate>MainBuilding.VillageName</div>
		</h6>
		<div class="contentBoxBody">
			<input ng-disabled="isSitter" type="text" maxlength=20 ng-model="villageName" auto-focus />
			<button ng-if="!isSitter" ng-class="{disabled: villageName == '' || village.name == villageName || villageName.length < 3}" clickable="setNewVillageName(villageName)">
				<span translate>Button.Save</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Button.Save</span>
			</button>
			<div class="error" ng-if="error">
				<i class="symbol_warning_tiny_flat_red"></i> {{error}}
			</div>
		</div>
	</div>

	<div class="foundTown contentBox gradient">
		<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
			<i class="village_city_medium_flat_black"></i>

			<div class="content" translate>MainBuilding.TownFounding</div>
		</h6>
		<div class="contentBoxBody">
			<table class="townConditionTable transparent" ng-class="{town: village.isTown}">
				<tbody>
				<tr>
					<th ng-if="!village.isTown">
						<div><i class="unit_culturePoint_small_illu"></i><span translate>MainBuilding.CulturePoints</span></div>
					</th>
					<td ng-if="village.isTown" rowspan="2">
						<div translate>MainBuilding.TownInfo</div>
					</td>
					<th><i class="unit_population_small_illu"></i><span translate>MainBuilding.Population</span></th>
				</tr>
				<tr>
					<td ng-if="!village.isTown">
						<span ng-class="{'green': townPreconditions.culturePoints >= townPreconditions.culturePointsForTown}" class="currentValue">{{townPreconditions.culturePoints}}</span>
						<span translate>Precondition.Of</span>
						<span>{{townPreconditions.culturePointsForTown}}</span>
					</td>
					<td>
						<span ng-class="{'green': village.population >= townPreconditions.population}" class="currentValue">{{village.population}}</span>
						<span ng-if="!village.isTown">
							<span translate>Precondition.Of</span>
							<span>{{townPreconditions.population}}</span>
						</span>
					</td>
				</tr>
				</tbody>
			</table>
			<table class="townUpgradeTable transparent">
				<tbody>
				<tr>
					<td class="doubleCol">
						<div class="buildingDescription">
							<span translate ng-if="village.isTown">Building.Town.Advantages</span>
							<span translate ng-if="!village.isTown">Building.Town.Description</span>
							<br/><br/>
							<span translate data="bonusCulturePoints:{{townAdditionalCultureProduction}},bonusPopulation:{{townAdditionalPopulation}},bonusAcceptance:{{acceptanceMaxForTown}}">Building.Town.AdvantagesList</span>
						</div>
					</td>
					<td>
						<button ng-class="{disabled: village.isTown || !mayUpgradeToTown()}"
								clickable="openOverlay('townFounding')">
							<span translate>Button.UpgradeToTown</span>
						</button>
					</td>
				</tr>
				</tbody>
			</table>
			<div class="error" ng-if="errorUpgrade">
				<i class="symbol_warning_tiny_flat_red"></i> {{errorUpgrade}}
			</div>
		</div>
	</div>

	<div class="demolish contentBox gradient">
		<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
			<i ng-if="!isRubble" class="action_delete_medium_flat_black"></i>
			<i ng-if="isRubble" class="action_dismantle_medium_flat_black"></i>

			<div ng-if="!isRubble" class="content" translate>MainBuilding.Demolish.Title</div>
			<div ng-if="isRubble" class="content" translate>MainBuilding.Rubble.Title</div>
		</h6>
		<div class="contentBoxBody">
			<table class="demolishTable transparent">
				<tbody>
				<tr>
					<td class="doubleCol">
						<div class="condition" ng-if="building.data.lvl < 10" translate>MainBuilding.Demolish.Condition</div>
						<div dropdown data="dropdown" ng-if="building.data.lvl >= 10 && demolishQueue.length <= 0"></div>
						<div class="demolishContainer" ng-if="building.data.lvl >= 10 && demolishQueue.length > 0">
							<span class="buildingName" translate options="{{demolishQueue[0].buildingType}}">Building_?</span>

							<div class="barContainer">
								<span class="ticker" countdown="{{demolishQueue[0].finished}}"></span>
								<div progressbar finish-time="{{demolishQueue[0].finished}}" duration="{{demolishQueue[0].finished - demolishQueue[0].timeStart}}"></div>
							</div>
						</div>
					</td>
					<td>
						<button ng-if="demolishQueue.length <= 0"
								ng-class="{disabled: building.data.lvl < 10 || dropdown.selected == null || isSitter}"
								tooltip
								tooltip-translate-switch="{
									'Sitter.DisabledAsSitter': {{isSitter == true}},
									'MainBuilding.Demolish.Condition': {{building.data.lvl < 10}},
									'ChoseBuilding': {{dropdown.selected == null}}
								}"
								clickable="demolish()">
							<span translate>Button.Demolish</span>
						</button>
						<button ng-if="demolishQueue.length > 0 && !isSitter && !isRubble"
								class="cancel"
								clickable="cancel()">
							<span translate>Button.Cancel</span>
						</button>
						<button ng-if="demolishQueue.length > 0 && !isSitter && isRubble"
								class="disabled"
								tooltip
								tooltip-translate="Rubble.Collecting">
							<span translate>Button.Cancel</span>
						</button>
						<button ng-if="demolishQueue.length > 0 && isSitter"
								class="disabled"
								tooltip
								tooltip-translate="Sitter.DisabledAsSitter">
							<span translate>Button.Cancel</span>
						</button>
					</td>
				</tr>
				<tr ng-if="isRubble" class="rubbleResources">
					<td class="doubleCol rubbleResources">
						<display-resources resources="rubbleResources"
										   signed="true"
										   color-positive="true"
										   check-storage="true"></display-resources>
					</td>
					<td></td>
				</tr>
				</tbody>
			</table>
			<div class="error" ng-if="errorDemolish">
				<i class="symbol_warning_tiny_flat_red"></i> {{errorDemolish}}
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/mainBuilding/overlay/townFoundingConfirmation.html"><div>
    <p class="townFoundingConfirmationDescription">
        <i class="symbol_warning_tiny_flat_red"></i>
        <span translate>MainBuilding.TownFounding.Description</span>
    </p>
</div>
<div class="buttonFooter">
    <button clickable="upgradeToTown();">
        <span translate>MainBuilding.TownFounding.Found</span>
    </button>
    <button clickable="closeOverlay();" class="cancel">
        <span translate>Button.Cancel</span>
    </button>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/marketplace_main.html"><div class="buildingDetails marketplace" ng-controller="marketplaceCtrl">
	<div ng-show="isBuildingBuild()">
        <div ng-include="tabBody"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/overlay/noResourceSendToOthers.html"><span translate>Marketplace.Send.Overlay.NoResourceSendToOthers</span>

<div class="buttonFooter">
	<button clickable="closeOverlay();" class="cancel jsCancelButtonCoronation">
		<span translate>Button.Cancel</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/partials/editTradeRoute.html"><div class="marketplace">
	<div ng-include="'tpl/building/marketplace/tabs/Send.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/partials/merchantsHeader.html"><div class="headerWithIcon arrowDirectionTo contentBoxHeader">
	<i class="movement_trade_medium_flat_black"></i>

	<div class="marketplaceHeaderGroup currentRequired">
		<span><span translate>Marketplace.Send.Traders</span>:</span>

		<div class="circle"><span>{{requiredMerchants}}</span></div>
	</div>
	<div class="marketplaceHeaderGroup">
		<span><span translate>Marketplace.Send.Available</span>:</span>

		<div class="circle"><span>{{merchants.data.merchantsFree}}</span></div>
	</div>
	<div class="marketplaceHeaderGroup">
		<span><span translate>Marketplace.Send.Transit</span>:</span>

		<div class="circle"><span>{{merchants.data.inTransport}}</span></div>
	</div>
	<div class="marketplaceHeaderGroup">
		<span><span translate>Marketplace.Send.Selling</span>:</span>

		<div class="circle"><span>{{merchants.data.inOffers}}</span></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/partials/resourceFilter.html"><div class="resourceFilter filterBar">
	<a class="filter iconButton" clickable="select(1);" ng-class="{active: resourceObj.type == 1, disabled: disabledEntry == 1}" tooltip tooltip-translate="Resource_1">
		<i class="unit_wood_small_illu"></i>
	</a>
	<a class="filter iconButton" clickable="select(2);" ng-class="{active: resourceObj.type == 2, disabled: disabledEntry == 2}" tooltip tooltip-translate="Resource_2">
		<i class="unit_clay_small_illu"></i>
	</a>
	<a class="filter iconButton" clickable="select(3);" ng-class="{active: resourceObj.type == 3, disabled: disabledEntry == 3}" tooltip tooltip-translate="Resource_3">
		<i class="unit_iron_small_illu"></i>
	</a>
	<a class="filter iconButton" clickable="select(4);" ng-class="{active: resourceObj.type == 4, disabled: disabledEntry == 4}" tooltip tooltip-translate="Resource_4">
		<i class="unit_crop_small_illu" ></i>
	</a>
</div>
</script>
<script type="text/ng-template" id="tpl/building/marketplace/partials/tradeRoute.html"><div class="tradeRoutePanel">
	<div ng-if="editable=='false'" class="whiteSpace"></div>
	<div class="timelineContainer" ng-class="{editable: editable!='false'}">
		<div ng-if="paused" class="pauseOverlay" translate>TradeRoutes.Paused</div>
		<table class="timeline transparent" ng-class="{dragging: dragging}">
			<tbody>
			<tr>
				<td ng-repeat="n in [] | range:0:23">
					<div ng-if="$first" class="timeOverflow travelDuration" ng-style="{width:getTimelineOverflowWidth()}"></div>
					<div class="timeMarker">
						<div class="hour-{{n}}" ng-show="startMarkers[n]" ng-class="{clickable: editable!='false'}">
							<div class="markerSymbol"></div>
							<div class="label">{{n}}</div>
							<div class="travelDuration" ng-style="{width:travelBarWidth}"></div>
							<div ng-if="recurrences>1" class="recurrences">
								<table>
									<tbody>
									<tr>
										<td ng-repeat="m in [] | range:1:recurrences"></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
						<i class="deleteMarker"
						   ng-class="{action_cancel_tiny_flat_black: !cancelHover, action_cancel_tiny_flat_red: cancelHover}"
						   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"
						   ng-if="editable!='false'"
						   ng-show="startMarkers[n]"
						   clickable="removeStartMarker(n)"></i>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div ng-if="editable=='false'" class="whiteSpace"></div>
	<button ng-if="editable!='false'" class="addButton clickable" ng-class="{disabled: !freeSpace}" clickable="addStartMarker()">+</button>
</div>
</script>
<script type="text/ng-template" id="tpl/building/marketplace/partials/transport.html"><table cellspacing="1" cellpadding="1" class="traders">
	<thead>
		<tr>
			<td>
				<span>
					<span player-link playerId="{{transport.playerId}}" playerName="{{transport.playerName}}"></span>
				</span>
			</td>
			<td>
                <span translate ng-if="!transport.returnMovement" options="{{transport.movement.movementType}}"
                           data="villageId: {{transport.movement.villageIdTarget}}, village: {{transport.movement.villageNameTarget}}">
                    RallyPoint.Troops.MovementType_?</span>
                <span translate ng-if="transport.returnMovement" options="{{transport.movement.movementType}}"
                           data="villageId: {{transport.movement.villageIdStart}}, village: {{transport.movement.villageNameStart}}">
                    RallyPoint.Troops.MovementType_?</span>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th><span translate>Marketplace.Transport.Arrival</span></th>
			<td>
				<span>
					<span translate data="time: {{transport.movement.timeFinish}}">Marketplace.Transport.ArrivalTime</span>
				</span>
			</td>
		</tr>
		<tr>
			<th><span translate>Resources</span></th>
			<td ng-if="transport.movement.movementType == 7">
				<i class="unit_wood_small_illu"></i> {{transport.movement.resources.1}}
				<i class="unit_clay_small_illu"></i> {{transport.movement.resources.2}}
				<i class="unit_iron_small_illu"></i> {{transport.movement.resources.3}}
				<i class="unit_crop_small_illu"></i> {{transport.movement.resources.4}}
			</td>
            <td ng-if="transport.movement.movementType != 7" class="info">
                <i class="unit_wood_small_illu"></i> {{transport.movement.resources.1}}
                <i class="unit_clay_small_illu"></i> {{transport.movement.resources.2}}
                <i class="unit_iron_small_illu"></i> {{transport.movement.resources.3}}
                <i class="unit_crop_small_illu"></i> {{transport.movement.resources.4}}
            </td>
		</tr>
	</tbody>
</table></script>
<script type="text/ng-template" id="tpl/building/marketplace/tabs/Buy.html"><div ng-controller="buyMarketplaceCtrl" class="marketContent marketBuy">
	<div class="filterWrapper contentBox">
		<div ng-include="'tpl/building/marketplace/partials/merchantsHeader.html'" class="merchantsHeader"></div>
		<div class="contentBoxBody marketBuyFilter">
			<div class="filterBox searchFilter">
				<div translate>Marketplace.Search_Want</div>
				<div>
					<span resource-filter deselectable="true" resource-obj="filter.search" on-change="filterChanged('search');"></span-filter>
				</div>
			</div>
			<div class="filterBox ratioFilter">
				<div translate>Marketplace.Rate</div>
				<div class="filterBar">
					<a class="filter iconButton oneToOne" clickable="selectRate(1);" ng-class="{active: filter.rate == 1 }" tooltip tooltip-translate="Marketplace.Buy.11filter">1:1</a>
					<a ng-if="hasMerchantRight" class="filter iconButton oneToX" clickable="selectRate(0);" ng-class="{active: filter.rate == 0 }" tooltip tooltip-translate="Marketplace.Buy.1xfilter">1:x</a>
					<a ng-if="!hasMerchantRight" class="filter iconButton oneToX disabled"  tooltip tooltip-translate="Sitter.NotEnoughRightsTooltip">1:x</a>
				</div>
			</div>
			<div class="filterBox offerFilter">
				<div translate>Marketplace.Offer_Have</div>
				<div>
					<span resource-filter deselectable="true" resource-obj="filter.offer" on-change="filterChanged('offer');"></span-filter>
				</div>
			</div>
		</div>
	</div>
	<div class="marketOffers">
		<div pagination items-per-page="itemsPerPage"
					number-of-items="numberOfItems"
					current-page="filter.page"
					display-page-func="displayCurrentPage"
					route-named-param="cp">
			<table class="tradeTable">
				<thead>
				<tr>
					<th translate>Marketplace.Have</th>
					<th translate>Marketplace.Rate</th>
					<th translate>Marketplace.Want</th>
					<th translate>Marketplace.Seller</th>
					<th translate>Duration</th>
					<th translate>Action</th>
				</tr>
				</thead>
				<tbody ng-repeat="offer in marketOffers">
				<tr>
					<td class="nowrap"><i class="unit_{{offer.offeredResource|resource}}_small_illu"></i> {{offer.offeredAmount}}</td>
					<td class="buyRateData"><span>{{ offer.searchedAmount / offer.offeredAmount | number:1 }}</span></td>
					<td class="nowrap"><i class="unit_{{offer.searchedResource|resource}}_small_illu"></i> {{offer.searchedAmount}}</td>
					<td class="nameColumn">
						<span player-link playerId="{{offer.playerId}}" playerName="{{offer.playerName}}"></span>
					</td>
					<td>{{offer.duration|HHMMSS}}</td>
					<td ng-class="{buttonContainer: !offer.inactive}">
						<button ng-show="!offer.inactive" clickable="acceptOffer({{offer.offerId}});"
							ng-class="{disabled: (offer.searchedAmount > stock[offer.searchedResource] && merchants.data.merchantsFree > 0) ||
								((offer.searchedAmount > merchants.data.maxCapacity && !(offer.searchedAmount > stock[offer.searchedResource])) || merchants.data.merchantsFree == 0)}"
							tooltip tooltip-translate-switch="{
								'Error.NotEnoughResources': {{(offer.searchedAmount > stock[offer.searchedResource] && merchants.data.merchantsFree > 0)}},
								'Error.NotEnoughMerchants': {{((offer.searchedAmount > merchants.data.maxCapacity && !(offer.searchedAmount > stock[offer.searchedResource])) || merchants.data.merchantsFree == 0)}}
							}">
							<span translate>Marketplace.Buy.Accept</span>
						</button>
						<div ng-show="offer.inactive" class="marketIconContainer">
							<span class="icon ">
							<i class="action_check_small_flat_green"
							   tooltip
							   tooltip-translate="Marketplace.Buy.AcceptedOfferSuccess"></i>
							</span>
						</div>
					</td>
				</tr>
				</tbody>
				<tr ng-if="marketOffers.length == 0">
					<td colspan="6" translate class="info">
						Marketplace.NoOffers
					</td>
				</tr>
			</table>
			<div class="acceptedOffer" ng-show="acceptedOffer.offerId">
				<span translate data="playerId:{{acceptedOffer.playerId}},playerName:{{acceptedOffer.playerName}}">
					Marketplace.Buy.AcceptedOffer
				</span>
			</div>
			<div class="error" ng-show="error">
				<i class="symbol_warning_tiny_flat_red"></i> {{ error }}
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/tabs/Merchants.html"><div class="marketplaceMerchants" ng-controller="merchantsMarketplaceCtrl">
	<div class="contentBox outbound">
		<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="movement_trade_medium_flat_black"></i>
			<span translate>TroopMovementInfo_outgoing_merchant</span>
		</div>
		<div class="contentBoxBody">
			<div ng-repeat="troopDetails in traders.outgoing | orderBy: 'movement.timeFinish'">
				<troop-details-rallypoint troop-details="troopDetails"></troop-details-rallypoint>
			</div>
			<div ng-if="traders.outgoing.length == 0" translate>
				Marketplace.Merchants.NoMovementPresent
			</div>
		</div>
	</div>
	<div class="contentBox inbound">
		<div class="contentBoxHeader headerWithIcon arrowDirectionFrom">
			<i class="movement_trade_medium_flat_black"></i>
			<span translate>TroopMovementInfo_incoming_merchant</span>
		</div>
		<div class="contentBoxBody">
			<div ng-repeat="troopDetails in traders.incoming | orderBy: 'movement.timeFinish'">
				<troop-details-rallypoint troop-details="troopDetails"></troop-details-rallypoint>
			</div>
			<div ng-if="traders.incoming.length == 0" translate>
				Marketplace.Merchants.NoMovementPresent
			</div>
		</div>
		<div class="contentBoxHeader headerWithIcon arrowDirectionFrom">
			<i class="movement_trade_medium_flat_black"></i>
			<span translate>TroopMovementInfo_incoming_merchant_return</span>
		</div>
		<div class="contentBoxBody">
			<div ng-repeat="troopDetails in traders.returns | orderBy: 'movement.timeFinish'">
				<troop-details-rallypoint troop-details="troopDetails"></troop-details-rallypoint>
			</div>
			<div ng-if="traders.returns.length == 0" translate>
				Marketplace.Merchants.NoMovementPresent
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/tabs/NpcTrade.html"><div ng-controller="npcMerchantCtrl" class="marketContent npcTrader contentBox">
	<div class="headerWithIcon arrowDirectionTo contentBoxHeader">
		<i class="movement_trade_medium_flat_black"></i>
		<span translate>Tab.NpcTrade</span>
	</div>
	<div class="contentBoxBody npcTraderDescription">
		<p translate>Marketplace.NpcTrade.Description_1</p>

		<p translate>Marketplace.NpcTrade.Description_2</p>
	</div>
	<table class="resourcesTable transparent contentBoxBody">
	<tbody class="sliderTable">
		<tr ng-repeat="(resourceType, resName) in resNames">
			<td class="resCol" tooltip tooltip-translate="Resource_{{resourceType}}">
				<i class="unit_{{resName}}_medium_illu"></i>
				<span class="resourceAmount {{resName}}Amount">{{Math.max(0,Math.floor(resources[resourceType]))}}</span>
			</td>
			<td class="sliderCol">
				<div class="sliderArrow"></div>
				<slider class="resSlider"
						slider-min="0" slider-max="sliderMax" slider-show-max-button="false"
						slider-lock="resourceData[resourceType]['locked']"
						slider-data="resourceData[resourceType]"
						slider-changed="sliderChanged"></slider>
				<div class="lockButtonContainer"
					 ng-class="{open: !resourceData[resourceType]['locked'], disabled: !resourceData[resourceType]['locked'] && lockedResources > 1}"
					 clickable="toggleResourceLock({{resourceType}})">
					<div class="lockButtonBackground"></div>
					<div class="lockSymbol"></div>
				</div>
			</td>
			<td class="diffCol">
					<span ng-class="{positive: resourceData[resourceType]['diff'] > 0, negative: resourceData[resourceType]['diff'] < 0}">
						{{resourceData[resourceType]['diff']}}</span>
			</td>
		</tr>
		<tr class="sumRow">
			<td class="resCol" colspan="3">
				{{resourcesSum}}
			</td>
		</tr>
		</tbody>
	</table>
	<div class="buttonBar contentBoxBody">
		<div ng-if="error">
			<span class="error">
				<i class="symbol_warning_tiny_flat_red"></i> {{error}}
			</span>
			<div class="horizontalLine"></div>
		</div>


		<div ng-show="freeResources == 0" class="merchantBtn">
			<button class="premium {{npcTradingAvailable}}"
					premium-feature="{{NPCTraderFeatureName}}"
					ng-class="{disabled: totalDiff == 0 || npcTradingAvailable == 'notAvailable'}"
					tooltip tooltip-translate="Building.npcTrader.Tooltip.WWVillage" tooltip-hide="{{npcTradingAvailable != 'notAvailable'}}">
				<span translate>Button.Redeem</span>
			</button>
		</div>
		<div ng-hide="freeResources == 0" class="merchantBtn">
			<button clickable="distribute()" ng-class="{disabled: totalDiff == 0}">
				<span translate>Marketplace.NpcTrade.Distribute</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/tabs/Sell.html"><div ng-controller="sellMarketplaceCtrl" class="marketContent marketSell">
	<div class="filterWrapper contentBox">
		<div ng-include="'tpl/building/marketplace/partials/merchantsHeader.html'" class="merchantsHeader"></div>
		<div class="createOffer contentBoxBody">
			<div class="filterBox">
				<div class="offerBox">
					<label for="marketNewOfferOfferedAmount">
						<span translate>Marketplace.Offer_Have</span>
						<span resource-filter resource-obj="filter.offer" deselectable="false" on-change="filterChanged()"></span-filter>
					</label>
					<input id="marketNewOfferOfferedAmount" ng-model="newOffer.offeredAmount" number="{{merchants.data.merchantsFree*merchants.data.carry}}" auto-focus/>
				</div>
				<div class="infoBox">
					<div class="rateWrapper">
						<div class="header" translate>Marketplace.Rate</div>
						<div class="rate">{{newOffer.searchedAmount / newOffer.offeredAmount | number:2}}</div>
					</div>
					<div class="merchantsNeededWrapper">
						<div class="header" translate>
							Marketplace.Merchant
						</div>
						<div class="merchantsNeeded">
							{{newOffer.neededMerchants}}
						</div>
					</div>
				</div>
				<div class="searchBox">
					<label for="marketNewOfferSearchedAmount">
						<span translate>Marketplace.Search_Want</span>
						<span resource-filter resource-obj="filter.search" deselectable="false" on-change="filterChanged()"></span-filter>
					</label>
					<input id="marketNewOfferSearchedAmount" ng-model="newOffer.searchedAmount" number="99999"/>
				</div>
			</div>
			<div class="parameters">
				<div class="limitDuration wrapper">
					<input id="limitDurationValue" ng-model="newOffer.limitDurationValue" number="{{maxLimitDurationValue}}">
					<label for="limitDurationValue">
						<span translate>Marketplace.Sell.LimitDuration</span>
					</label>
				</div>
				<div class="allyOnly wrapper" ng-show="player.data.allianceId > 0 && ((currentServerTime-player.data.spawnedOnMap)/86400) >= 7">
					<input type="checkbox" id="limitAlly" ng-model="newOffer.limitAlly" />
					<label for="limitAlly">
						<span translate>Marketplace.Sell.LimitAlly</span>
					</label>
				</div>

				<button class="createOfferBtn" clickable="createOffer();" ng-class="{disabled: newOffer.searchedAmount <= 0 || newOffer.offeredAmount <= 0}">
					<span translate>Marketplace.Sell</span>
				</button>
			</div>
		</div>
	</div>

	<div class="ownOffers">
		<div pagination items-per-page="itemsPerPage"
					number-of-items="numberOfItems"
					current-page="filter.page"
					display-page-func="displayCurrentPage"
					route-named-param="cp">
			<table class="tradeTable">
			<thead>
				<tr>
					<th translate>Marketplace.Have</th>
					<th translate>Marketplace.Rate</th>
					<th translate>Marketplace.Want</th>
					<th translate>Marketplace.Merchant</th>
					<th translate>Alliance</th>
					<th translate>Duration</th>
					<th class="actions" translate>Action</th>
				</tr>
				</thead>
				<tbody ng-repeat="offer in ownOffersPage">
				<tr>
					<td class="nowrap"><i class="unit_{{offer.data.offeredResource|resource}}_small_illu"></i> {{offer.data.offeredAmount}}</td>
					<td><span>{{ offer.data.searchedAmount / offer.data.offeredAmount | number:2 }}</span></td>
					<td class="nowrap"><i class="unit_{{offer.data.searchedResource|resource}}_small_illu"></i> {{offer.data.searchedAmount}}</td>
					<td>{{offer.data.blockedMerchants}}</td>
					<td>
						<span translate ng-show="offer.data.limitAlly">Yes</span>
						<span translate ng-show="!offer.data.limitAlly">No</span>
					</td>
					<td>
						<span ng-show="!offer.data.limitDuration">--</span>
							<span ng-show="offer.data.limitDuration"><span translate data="hours: {{offer.data.maximumDuration}}">
								Marketplace.Sell.OfferDuration
							</span></span>
					</td>
					<td class="actions">
						<i class="deleteOffer"
						   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
						   clickable="cancelOffer({{offer.data.offerId}});"
						   tooltip tooltip-translate="Marketplace.Sell.DeleteOffer"></i>
					</td>
				</tr>
				</tbody>
				<tr ng-if="ownOffersPage.length == 0">
					<td colspan="7" translate class="info">
						Marketplace.NoOffers
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="error" ng-show="sellMarketError">
		<i class="symbol_warning_tiny_flat_red"></i>{{ sellMarketError }}
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/tabs/Send.html"><div class="marketContent marketSend">
	<div ng-controller="sendMarketplaceCtrl" class="contentBox">
		<div ng-include="'tpl/building/marketplace/partials/merchantsHeader.html'" class="merchantsHeader" ng-if="!editTradeRoute"></div>
		<div class="contentBoxBody">
			<table class="resourcesTable transparent" ng-class="{editTradeRoute: editTradeRoute}">
				<tbody class="sliderTable">
				<tr ng-repeat="(resourceType, resName) in resNames">
					<td class="resCol" tooltip tooltip-translate="Resource_{{resourceType}}">
						<i class="unit_{{resName}}_medium_illu"></i>
						<span class="resourceAmount {{resName}}Amount">{{Math.max(0,Math.floor(stock[resourceType]))}}</span>
					</td>
					<td class="sliderCol">
						<div class="sliderArrow"></div>
						<slider class="resSlider"
								slider-min="0"
								slider-max="sliderMax"
								slider-show-max-button="false"
								slider-data="resourceData[resourceType]"
								slider-changed="sliderChanged"
								slider-steps="merchants.data.carry"
								force-steps="false"
								slider-markers="resourceData[resourceType]['markers']"></slider>
					</td>
					<td class="merchantCol">
						<a class="clickable" clickable="addMerchant({{resourceType}})">{{merchants.data.carry | bidiNumber:'':true:true}}</a>
					</td>
				</tr>
				</tbody>
				<tbody>
				<tr>
					<td class="requiredCol" colspan="3">
						<span ng-if="editTradeRoute" translate data="required: {{requiredMerchants}}, total: {{merchants.data.merchantsFree}}">Marketplace.Send.MerchantsRequired</span>
						<span class="carrySum" ng-bind-html="selectedCarrySum | bidiRatio : selectedCarrySum : (merchants.data.merchantsFree * merchants.data.carry)"></span>
					</td>
				</tr>
				</tbody>
			</table>

			<table class="settingsTable transparent" ng-class="{editTradeRoute: editTradeRoute}">
				<tbody>
				<tr>
					<th class="destinationCol">
						<span translate>Marketplace.Send.Destination</span>
						<span class="duration" ng-show="travelDuration">{{travelDuration|HHMMSS}}</span>
					</th>
					<th ng-if="plusAccount" translate>Marketplace.Send.Recurrences</th>
					<th></th>
				</tr>
				<tr>
					<td>
						<serverautocomplete
								class="targetInput"
								autocompletedata="village,playerVillages,coords"
								autocompletecb="checkTarget"
								ng-model="targetInput"
								show-own-villages="true"
								input-autofocus="true"></serverautocomplete>
						<div ng-show="targetPlayer !== null && targetInput !== null && targetInput != '' && !editTradeRoute"><span translate>Player</span>: <span player-link playerId="{{targetPlayer.data.playerId}}" playerName="{{targetPlayer.data.name}}"></span></div>
					</td>
					<td ng-show="traderSlots > 0" class="repetitions">
						<div class="filterBar">
							<a class="filter iconButton" ng-class="{active: $parent.recurrences == n}" ng-repeat="n in [] | range:1:traderSlots" clickable="changeRecurrence(n)">
							<span>{{n}}</span>
							</a>
							<button ng-if="!firstExtraTraderSlot" class="buyExtraSlot premium"
									premium-feature="{{::traderSlotFeatureName}}" confirm-gold-usage="force"
									tooltip tooltip-translate="Marketplace.Send.Tooltip.ExtraTraderSlot" tooltip-data="slotPrice: {{firstExtraTraderSlotPrice}}">
								<i class="symbol_plus_tiny_flat_black"></i>
							</button>
							<button ng-if="!secondExtraTraderSlot" class="buyExtraSlot premium"
									premium-feature="{{::traderSlotFeatureName}}" confirm-gold-usage="force"
									tooltip tooltip-translate="Marketplace.Send.Tooltip.ExtraTraderSlot" tooltip-data="slotPrice: {{secondExtraTraderSlotPrice}}">
								<i class="symbol_plus_tiny_flat_black"></i>
							</button>
						</div>
					</td>
					<td ng-if="!editTradeRoute && !showInstantDelivery">
						<button ng-class="{disabled: selectedCarrySum == 0 || !validTarget}"
								clickable="sendResources();"
								play-on-click="{{UISound.BUTTON_SEND_RESSOURCES}}">
							<span translate ng-if="!editTradeRoute">Marketplace.Send.Button.SendResources</span>
						</button>
					</td>
					<td ng-show="showInstantDelivery">
						<button class="premium instantDelivery"
								premium-feature="{{premiumFeatureName}}"
								premium-callback-param="{{premiumFeatureTroopId}}"
								price="{{premiumFeaturePrice}}">
							<span translate>RallyPoint.Overview.InstantDelivery</span>
						</button>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="error" ng-show="noResourceSendToOthers()">
							<i class="symbol_warning_tiny_flat_red"></i> <span translate>Marketplace.Send.Overlay.NoResourceSendToOthers</span>
						</div>
						<div class="error" ng-show="error != null && error != ''">
							<i class="symbol_warning_tiny_flat_red"></i><div ng-bind-html="error"></div>
						</div>
					</td>
				</tr>
				</tbody>
			</table>

			<div class="tradeRouteContainer" ng-if="editTradeRoute">
				<span class="scheduleCaption" translate>Marketplace.Send.TradingRouteSchedule</span>
				<trade-route time-code="$parent.routeCode" travel-duration="$parent.travelDuration" recurrences="$parent.recurrences" editable="true"></trade-route>
			</div>
			<div class="buttonBar"  ng-if="editTradeRoute">
				<div class="merchantBtn">
					<button ng-class="{disabled: selectedCarrySum == 0 || !validTarget || (editTradeRoute && routeCode == 0) || !plusAccount}"
							clickable="sendResources();"
							play-on-click="{{UISound.BUTTON_SEND_RESSOURCES}}">
						<span translate ng-if="editTradeRoute && tradeRouteId == -1">Marketplace.Send.Button.NewTradeRoute</span>
						<span translate ng-if="editTradeRoute && tradeRouteId >= 0">Marketplace.Send.Button.SaveTradeRoute</span>
					</button>
				</div>
			</div>
			<div ng-if="!editTradeRoute" ng-show="lastTrade !== null && lastTrade.data.movement.timeFinish > currentServerTime" class="buttonBar">
				<div class="contentBox lastTrade">
					<div class="contentBoxBody">
						<span translate class="headline" data="villageName: {{lastTrade.data.movement.villageNameTarget}}, villageId: {{lastTrade.data.movement.villageIdTarget}}, playerName: {{lastTrade.data.movement.playerNameTarget}}, playerId: {{lastTrade.data.movement.playerIdTarget}}">Marketplace.Send.LastTrade.Headline</span>
						<display-resources resources="lastTrade.data.movement.resources"></display-resources>
						<span translate class="timer" data="countdownTo: {{lastTrade.data.movement.timeFinish}}">countdownTo</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/marketplace/tabs/TradeRoute.html"><div class="tradeRoute" ng-controller="tradeRouteMarketplaceCtrl">
	<div  ng-show="!hasPlusAccount" translate>
		Marketplace.TradeRoutes.NoPlusAccount
	</div>
	<div ng-if="tradeRoutes.data.length == 0" ng-show="hasPlusAccount" translate>Marketplace.TradeRoutes.NoRoute</div>
	<div class="tradeRoutes" ng-if="tradeRoutes.data.length > 0" scrollable height-dependency="max">
		<div class="routeContainer" ng-repeat="route in tradeRoutes.data">
			<div class="controlPanel">
				<span translate data="villageId:{{route.data.destVillageId}},villageName:{{route.data.destVillageName}}">
					Marketplace.TradeRoutes.Description
				</span>
				({{route.data.merchants}} <span translate>Marketplace.TradeRoutes.UsedMerchants</span>)
				<div class="iconButton" ng-class="{disabled: !hasPlusAccount}"
					 clickable="deleteRoute($index)"
					 tooltip tooltip-translate="Marketplace.TradeRoutes.ToolTip.Delete">
					<i class="action_delete_small_flat_black"></i>
				</div>
				<div class="iconButton" ng-class="{disabled: !hasPlusAccount}"
					 clickable="editRoute($index)"
					 tooltip tooltip-translate="Marketplace.TradeRoutes.ToolTip.Edit">
					<i class="action_edit_small_flat_black"></i>
				</div>
				<div class="iconButton"
					 ng-class="{active: route.data.status, disabled: !hasPlusAccount}"
					 clickable="changeRouteStatus($index, 1)"
					 tooltip tooltip-translate="Marketplace.TradeRoutes.ToolTip.Resume" tooltip-show="{{route.data.status==0}}">
					<i class="tradeRoute_start_small_flat_black"></i>
				</div>
				<div class="iconButton"
					 ng-class="{active: !route.data.status || !hasPlusAccount}"
					 clickable="changeRouteStatus($index, 0)"
					 tooltip tooltip-translate="Marketplace.TradeRoutes.ToolTip.Pause" tooltip-show="{{route.data.status==1}}">
					<i class="tradeRoute_pause_small_flat_black"></i>
				</div>
			</div>
			<trade-route
				time-code="route.data.times"
				travel-duration="route.data.duration"
				recurrences="route.data.recurrences"
				editable="false"
				paused="route.data.status==0"></trade-route>
			<display-resources resources="route.data.resources"></display-resources>
			<div class="resourceTotal">
				<span translate>Marketplace.TradeRoutes.ResourceTotal</span> {{route.resources.getSum()}}
			</div>
		</div>
	</div>
	<div class="buttonContainer" ng-show="hasPlusAccount">
		<button class="newTradeRoute" clickable="addTradeRoutes()"><span translate>Marketplace.TradeRoutes.AddTradeRoute</span></button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/palace/expansion_main.html"><div class="buildingDetails expansion">
	<div ng-show="isBuildingBuild()">
        <div ng-include="tabBody"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/palace/palace_main.html"><div class="buildingDetails palace" ng-controller="palaceCtrl">
	<div ng-show="isBuildingBuild()">
        <div class="palaceBody">
            <div ng-include="tabBody"></div>
        </div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/palace/tabs/Acceptance.html"><div class="loyaltyOverview contentBox gradient">
	<div class="contentBoxBody">
		<div class="marginToScrollbar"></div>
		<div class="contentBox acceptanceOverview">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content" translate>Palace.Acceptance.ActualAcceptance</div>
			</h6>
			<div class="contentBoxBody">
				<div class="acceptanceInActiveVillage">
					<span translate>Palace.Acceptance.AcceptanceInActiveVillage</span>
					<span ng-class="{high: activeVillage.data.acceptance >= 100, low: activeVillage.data.acceptance < 100}">{{Math.floor(activeVillage.data.acceptance) | bidiNumber:'percent':false:false}} (<span translate data="prod:{{ Math.floor(activeVillage.data.acceptanceProduction) }}">Palace.Acceptance.PerHour</span>)</span>
				</div>
				<div>
					<div class="first">
						<p class="acceptanceDescription" translate>Palace.Acceptance.Description</p>
						<p class="acceptanceDescription2" translate>Palace.Acceptance.Description2</p>
					</div>
					<div class="middle verticalLine"></div>
					<div class="second" >
						<table class="acceptanceVillages fixedTableHeader" scrollable>
							<thead>
								<tr>
									<th class="name"><i class="village_village_small_flat_black" tooltip tooltip-translate="Villages"></i></th>
									<th class="population"><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i></th>
									<th class="acceptance" translate>TableHeader.Acceptance</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="village in villages | orderBy:['data.acceptance', 'data.name']">
									<td class="name"><span village-link villageid="{{village.data.villageId}}" villagename="{{village.data.name}}"></span></td>
									<td class="population">{{village.data.population}}</td>
									<td class="acceptance" ng-class="{high: village.data.acceptance >= 100, low: village.data.acceptance < 100}">{{Math.floor(village.data.acceptance) | bidiNumber:'percent':false:false}} (<span translate data="prod:{{ Math.floor(village.data.acceptanceProduction) }}">Palace.Acceptance.PerHour</span>)</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/palace/tabs/Capital.html"><div class="capital contentBox gradient" ng-controller="palaceCapitalCtrl">
	<div class="contentBoxBody">
		<div ng-if="building.data.buildingType == 26 && !isCapital" class="contentBox gradient capitalChange">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content" translate>Palace.CapitalChange</div>
			</h6>
			<div class="contentBoxBody">
				<div translate>Palace.CapitalChangeDescription1</div>
				<div translate>Palace.CapitalChangeDescription2</div>

				<div class="horizontalLine"></div>
				<div>
					<button class="disabled"
							tooltip
							tooltip-translate="Sitter.DisabledAsSitter"
							ng-if="isSitter">
						<span translate>Palace.CapitalChange</span>
					</button>

					<button ng-if="!isSitter" clickable="changeCapital();">
						<span translate>Palace.CapitalChange</span>
					</button>
				</div>

				<p class="error" ng-if="error">
					{{error}}
				</p>
			</div>
		</div>

		<div ng-if="building.data.buildingType != 26 || isCapital" class="contentBox gradient">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content" translate>Palace.CapitalDescriptionTitle</div>
			</h6>
			<div class="contentBoxBody">
				<div class="important" translate>Palace.CapitalDescriptionImportant</div>
				<span translate>Palace.CapitalDescription1</span>
				<ul translate>Palace.CapitalDescription2</ul>
				<span translate>Palace.CapitalDescription3</span>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/palace/tabs/CulturePoints.html"><div class="tabCulturePoints contentBox">
	<div class="contentBoxBody">
		<div class="rowContainer">
			<div class="first">
				<div class="contentBox usedSlots gradient">
					<h6 class="contentBoxHeader headerTrapezoidal">
						<div class="content" translate>ExpansionSlots.ExpansionList.OccupiedSlots</div>
					</h6>
					<table class="transparent contentBoxBody">
						<thead>
							<tr>
								<th></th>
								<th translate>ExpansionSlots.ExpansionList.Quantity</th>
								<th translate>ExpansionSlots.ExpansionList.SlotsUsed</th>
							</tr>
						</thead>
						<tbody>
							<tr class="dividerLine" ng-class="{active: expansionSlots.numberOfVillages > 0}">
								<td translate>Villages</td>
								<td>{{expansionSlots.numberOfVillages}}</td>
								<td>{{expansionSlots.numberOfVillages}}</td>
							</tr>
							<tr ng-class="{active: expansionSlots.numberOfTowns > 0}">
							<td translate>Towns</td>
								<td>{{expansionSlots.numberOfTowns}}</td>
								<td>{{expansionSlots.numberOfTowns * 2}}</td>
							</tr>
							<tr>
								<td colspan="3" class="placeholder"></td>
							</tr>
							<tr class="dividerLine" ng-class="{active: expansionSlots.numberOfVillages + expansionSlots.numberOfTowns > 0}">
								<td translate>Total</td>
								<td></td>
								<td>{{expansionSlots.numberOfVillages + expansionSlots.numberOfTowns * 2}}</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="culturePerDay contentBox gradient">
					<h6 class="contentBoxHeader headerTrapezoidal">
						<div class="content" translate>ExpansionSlots.CulturePerDay.Headline</div>
					</h6>
					<div class="contentBoxBody">
						<div class="symbol_i_tiny_wrapper">
							<i class="symbol_i_tiny_flat_white" tooltip tooltip-translate="ExpansionSlots.CulturePerDay.Description" tooltip-placement="after"></i>
						</div>
						<table class="transparent">
							<tbody>
								<tr ng-class="{active: cpProduction.activeVillage > 0}">
									<td translate>ExpansionSlots.CulturePerDay.ActiveVillage</td>
									<td>{{cpProduction.activeVillage}}</td>
								</tr>
								<tr class="dividerLine" ng-class="{active: cpProduction.otherVillages > 0}">
									<td translate>ExpansionSlots.CulturePerDay.OtherVillages</td>
									<td>{{cpProduction.otherVillages}}</td>
								</tr>
								<tr ng-class="{active: cpProduction.hero > 0}">
									<td translate>ExpansionSlots.CulturePerDay.Hero</td>
									<td>{{cpProduction.hero}}</td>
								</tr>
								<tr class="dividerLine" ng-class="{active: cpProduction.sum > 0}">
									<td translate>ExpansionSlots.CulturePerDay.Overall</td>
									<td>{{cpProduction.sum}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="second">
				<div class="slotOverview contentBox gradient">
					<h6 class="contentBoxHeader headerTrapezoidal">
						<div class="content" translate>ExpansionSlots.ExpansionList.NextCultureSlots</div>
					</h6>
					<div class="contentBoxBody">
						<div class="cultureSlot arrowContainer arrowDirectionTo" ng-class="{active: slot.required <= 0, disabled: slot.required > 0}" ng-repeat="slot in expansionSlots.slots">
							<span class="arrowInside">{{slot.slotNumber}}</span>
							<span class="arrowOutside" ng-if="slot.required <= 0" tooltip tooltip-translate="ExpansionSlots.ExpansionList.FreeSlot">{{slot.culturePoints}}</span>

							<div class="arrowOutside deactivated withProgress" ng-if="slot.required > 0 && slot.showDetails" tooltip tooltip-translate="ExpansionSlots.ExpansionList.AvailableIn" tooltip-data="time:{{expansionSlots.timeNeeded}}">
								<span>{{0 | bidiRatio:expansionSlots.producedCulturePoints:slot.culturePoints}}</span>
								<span class="countdown" ng-if="expansionSlots.timeNeeded - currentServerTime <= 172800" countdown="{{expansionSlots.timeNeeded}}"></span>
								<span class="countdown" ng-if="expansionSlots.timeNeeded - currentServerTime > 172800" i18ndt="{{expansionSlots.timeNeeded}}" relative="from"></span>
								<div progressbar perc="{{slot.percentage}}"></div>
							</div>
							<div class="arrowOutside deactivated" ng-if="slot.required > 0 && !slot.showDetails " tooltip tooltip-translate="ExpansionSlots.ExpansionList.NotAvailable">
							<span>{{0 | bidiRatio:expansionSlots.producedCulturePoints:slot.culturePoints}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/palace/tabs/Expansions.html"><div class="tabExpansions">
	<div>
		<div ng-controller="unitsTrainCtrl">
			<div ng-include src="'tpl/building/partials/lists/units.html'"></div>

			<button ng-class="{disabled: activeItem.disabled || activeItem.value <= 0 || !hasEnoughResources(activeItem.costs) || (usedControlPoint >= availableControlPoints || (activeItem.unitType == leaderId && (availableControlPoints - usedControlPoint) < 3))}"
					class="footerButton"
					clickable="startTraining(activeItem)"
					tooltip
					tooltip-translate-switch="{
						'ExpansionSlots.ExpansionList.NotEnoughSlotsAvailable': {{(usedControlPoint >= availableControlPoints || (activeItem.unitType == leaderId && (availableControlPoints - usedControlPoint) < 3))}},
						'TrainTroops.NotResearched': {{activeItem.disabled == true}},
						'TrainTroops.SetAmount': {{activeItem.value <= 0}},
						'Error.NotEnoughRes': {{!hasEnoughResources(activeItem.costs)}}
						}">
				<span translate>Button.Train</span>
			</button>
		</div>
	</div>
	<div class="expansionSlots contentBox gradient">
		<h6 class="contentBoxHeader headerTrapezoidal">
			<div class="content" translate>ExpansionSlots.ExpansionList.Slots</div>
		</h6>
		<div class="expansionList contentBoxBody">
			<div ng-repeat="slot in expensionSlots" class="expansionSlot arrowContainer arrowDirectionTo"
				 ng-class="{'active': slot.state == 'active' || slot.state == 'occupied', 'locked disabled': slot.state == 'locked'}">
				<span class="arrowInside">{{$index+1}}</span>

				<div class="slotUnlocks arrowOutside fullCentered" ng-if="slot.state == 'locked'">
					<div class="symbol_lock_small_wrapper">
						<i class="symbol_lock_small_flat_black"></i>
					</div>
					<span translate data="lvl:{{slot.level}}">ExpansionSlots.ExpansionList.Unlocks</span>
				</div>
				<div class="slotUnlocks arrowOutside fullCentered" ng-if="slot.state == 'active'">
					<span ng-if="slot.subState == 'free'" translate>ExpansionSlots.ExpansionList.Unlocked</span>
					<span ng-if="slot.subState == 'icons'">
						<span unit-icon class="unitIcon" ng-class="icon.className" data="icon.tribeId, icon.unitId" ng-repeat="icon in slot.subStateIcons"></span>
					</span>
				</div>
				<div class="slotVillage arrowOutside fullCentered" ng-if="slot.state == 'occupied'">
					<span village-link villageId="{{slot.data.villageId}}" villagename="{{slot.data.villageName}}"></span>
				</div>
			</div>
			<div class="expansionSlot arrowContainer arrowDirectionTo disabled" ng-if="isResidence">
				<span class="arrowInside">3</span>

				<div class="arrowOutside fullCentered" translate>ExpansionSlots.ExpansionList.OnlyPalace</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/buildCostsTooltip.html"><div class="buildCostsTooltip">
	<div ng-include src="'tpl/building/partials/upgradeCostsTooltip.html'"></div>
	<div class="horizontalLine"></div>
	<p translate options="{{building.data.buildingType}}" data="param:{{building.data.descriptionParam}}" class="description">Building.Description_?</p>
</div>
</script>
<script type="text/ng-template" id="tpl/building/partials/buildingHeader.html"><div class="contentHeader" ng-if="w.building.filled">
	<div ng-if="!w.building.isRubble()">
		<h2>
			<span translate class="building" options="{{w.building.data.buildingType}}">Building_?</span>
			<span class="level">
				(<span translate data="lvl:{{w.building.data.lvl}}">Building.Level</span>)
			</span>
		</h2>

		<div class="buildingDescription"
			 translate
			 options="{{w.building.data.buildingType}}"
			 data="param:{{w.building.data.descriptionParam}}">
			Building.Description_?
		</div>

		<img class="buildingHuge buildingType{{w.building.data.buildingType}} tribeId{{player.data.tribeId}} level{{w.building.data.lvl}}"
			 alt=""
			 src="layout/images/x.gif"
			 on-pointer-over="startBuildingSound()"/>
	</div>
	<div ng-if="w.building.isRubble()">
		<h2>
			<span translate class="building">Building_Rubble</span>
		</h2>
		<div class="buildingDescription" translate>Building_Description_Rubble</div>
		<img class="buildingHuge buildingTyperubble" src="layout/images/x.gif" alt="">
	</div>

	<span building-status class="buildingStatusButton type_{{w.building.data.buildingType}}"></span>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/buildingInformation.html"><div ng-include src="'tpl/building/partials/buildingInformationEffects.html'"></div></script>
<script type="text/ng-template" id="tpl/building/partials/buildingInformationDescription.html"><div class="buildingDescription">
	<span translate options="{{building.data.buildingType}}" data="param:{{building.data.descriptionParam}}">Building.Description_?</span>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/buildingInformationEffects.html"><div class="contentBox gradient buildingEffect"
	 ng-if="currentEffect.values[0] != undefined
	 		&& (building.data.lvl > 0
	 		|| building.data.buildingType <= 4
	 		|| building.data.buildingType == 42)">
	<h6 class="contentBoxHeader headerColored">
		<span translate options="{{building.data.buildingType}}"
				   data="lvl: {{currentEffect.lvl}}, value: {{currentEffect.value}}">
			Building.Effect_?
		</span>
	</h6>
	<div class="contentBoxBody">
		<div class="current">
			<h6 class="headerTrapezoidal">
				<div class="content" translate>
					Building.Current
				</div>
			</h6>
			<div class="currentLevel"
				 data="lvl: {{building.data.lvl}}"
				 translate>
				Building.Level
			</div>
			<div class="value">
				{{currentEffect.values[0]}}
			</div>
			<div class="unit" options="{{building.data.buildingType}}" translate>
				Building.EffectUnit_0_?
			</div>
		</div>
		<div class="nextLvl">
			<h6 class="headerTrapezoidal">
				<div class="content" translate>
					Building.NextLevels
				</div>
			</h6>
			<table ng-repeat="effect in nextEffects" ng-class="{}" class="transparent">
				<tbody>
					<tr ng-class="{upgrading: building.data.lvlNext > getFutureLevel($index)}">
						<th>{{getFutureLevel($index)}}</th>
						<td ng-if="building.data.lvlNext > getFutureLevel($index)" translate>Building.InUpgrade</td>
						<td>
							<span translate options="{{building.data.buildingType}}" data="value: {{effect}}">Building.EffectValue_0_?</span>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="maxLvl" ng-if="building.data.isMaxLvl && building.data.lvl == building.data.lvlMax">
			<span translate>Effect.BuildingMaxLvlReached</span>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/buildingLocation.html"><div ng-if="building.data.buildingType > 0">
	<img ng-if="viewBuilding.imgName != ''" class="location {{viewBuilding.imgClass}} buildingType{{viewBuilding.buildingType }}" ng-src="{{viewBuilding.imgPath}}{{ viewBuilding.imgName }}.png" crossOrigin="" id="buildingImage{{building.data.locationId}}" ng-style="viewBuilding.imgStyle">
	<img ng-if="secondImage.visible && secondImage.imgName != ''" class="location {{secondImage.imgClass}} buildingType{{ secondImage.imgName }}" ng-src="{{secondImage.imgPath}}{{ secondImage.imgName }}.png" crossOrigin="" ng-style="secondImage.imgStyle">
	<div ng-if="secondImage.visible && secondImage.imgName == ''" class="location {{secondImage.imgClass}} buildingType{{ secondImage.imgName }}" ng-style="secondImage.imgStyle"></div>
	<span building-status building="building"
		class="buildingStatusButton location type_{{::building.data.buildingType}} location_{{::building.data.locationId}}"
		ng-style="::viewBuilding.statusStyle" ng-if="!noStatus">
	</span>
</div>

<span ng-if="clickArea && (page != 'resources' || building.data.locationId <= 18) && enableSvgHighlighting">
	<svg ng-if="::clickArea.length == 1 && clickArea[0].paths.length == 1" ng-attr-width="{{clickArea[0].size.w || 1174}}" ng-attr-height="{{clickArea[0].size.h || 850}}"
		 ng-class="{highlight: onTopAreas && highlight[0]}"
		 ng-style="{'top': viewBuilding.imgStyle.top, 'left': viewBuilding.imgStyle.left, 'marginTop': clickArea[0].offset.y + 'px', 'zIndex': clickArea[0].z || viewBuilding.imgStyle.z-index}">
		<path class="single" ng-attr-d="{{clickArea[0].paths[0]}}" clickable="openWindow('building', {'location': building.data.locationId})"
			  filter="url(#{{building.data.buildingType == 0 ? 'location' : 'shape'}}Blur)"></path>
	</svg>
	<svg ng-if="::clickArea.length == 1 && clickArea[0].paths.length == 1 && onTopAreas" ng-attr-width="{{clickArea[0].size.w || 1174}}" ng-attr-height="{{clickArea[0].size.h || 850}}"
		 ng-style="{'top': viewBuilding.imgStyle.top, 'left': viewBuilding.imgStyle.left, 'marginTop': clickArea[0].offset.y + 'px', 'zIndex': 100 + (clickArea[0].z || viewBuilding.imgStyle.z-index)}"
		 class="onTopArea">
		<path class="single" ng-attr-d="{{clickArea[0].paths[0]}}" clickable="openWindow('building', {'location': building.data.locationId})"
			  on-pointer-over="highlight[0]=true;" on-pointer-out="highlight[0]=false;"
			  filter="url(#{{building.data.buildingType == 0 ? 'location' : 'shape'}}Blur)"></path>
	</svg>
	<span ng-if="::clickArea.length != 1 || clickArea[0].paths.length != 1" ng-class="{highlight: highlight[0]}">
		<svg ng-repeat="area in clickArea" ng-attr-width="{{area.size.w || 1174}}" ng-attr-height="{{area.size.h || 850}}"
			 ng-style="{'top': viewBuilding.imgStyle.top, 'left': viewBuilding.imgStyle.left, 'marginTop': area.offset.y + 'px', 'zIndex': area.z || viewBuilding.imgStyle.z-index}">
			<path ng-repeat="path in area.paths" ng-attr-d="{{path}}" clickable="openWindow('building', {'location': building.data.locationId})"
				  on-pointer-over="highlight[0]=true;" on-pointer-out="highlight[0]=false;"
				  filter="url(#{{building.data.buildingType == 0 ? 'location' : 'shape'}}Blur)"></path>
		</svg>
		<svg ng-if="::onTopAreas" class="onTopArea" ng-repeat="area in clickArea" ng-attr-width="{{area.size.w || 1174}}" ng-attr-height="{{area.size.h || 850}}"
			 ng-style="{'top': viewBuilding.imgStyle.top, 'left': viewBuilding.imgStyle.left, 'marginTop': area.offset.y + 'px', 'zIndex': 100 + (area.z || viewBuilding.imgStyle.z-index)}">
			<path ng-repeat="path in area.paths" ng-attr-d="{{path}}" clickable="openWindow('building', {'location': building.data.locationId})"
				  on-pointer-over="highlight[0]=true;" on-pointer-out="highlight[0]=false;"
				  filter="url(#{{building.data.buildingType == 0 ? 'location' : 'shape'}}Blur)"></path>
		</svg>
	</span>
</span></script>
<script type="text/ng-template" id="tpl/building/partials/buildingRequirement.html"><div class="requiredBuildings">
	<h4 translate>Requirements</h4>
	<span class="buildingInfo" tooltip tooltip-translate="Tooltip.CurrentLevel" tooltip-data="number:{{building.currentLevel}}" ng-repeat="(i,building) in buildings">
		<a clickable="openWindow('help', {'pageId': 'Buildings_' + building.buildingType})"  translate options="{{building.buildingType}}">Building_?</a> <span translate data="lvl:{{building.requiredLevel}}">Building.Level</span>
		<span ng-if="!building.valid" class="neededLevels">({{(building.requiredLevel-building.currentLevel) | bidiNumber:'':true:true}})</span>
	</span>
	<span ng-repeat="requirement in otherRequirements">, <span translate data="required:{{requirement.requiredValue}},current:{{requirement.currentValue}}" options="{{requirement.langKey}}">?</span>
		<span ng-if="requirement.valid === false" class="neededLevels">({{(requirement.requiredValue-requirement.currentValue) | bidiNumber:'':true:true}})</span>
	</span>
	<span ng-if="!buildings.length && !otherRequirements" translate>Building.Prerequisite.None</span>
</div>
</script>
<script type="text/ng-template" id="tpl/building/partials/dismantleCostsTooltip.html"><div class="upgradeCostsTooltip">
	<div class="headline">
		<h3 class="building"><span translate options="{{building.data.buildingType}}">Building_?</span></h3>
	</div>
	<div class="content dismantle">
		<div class="contentTopArea">
			<div class="effectDescription">
				<span ng-if="upgradeButtonClass == 'demolish'" translate>Dismantle.Tooltip.InProgress</span>
				<span ng-if="upgradeButtonClass != 'demolish'" translate>Building_ShortDescription_Rubble</span>
				<div class="horizontalLine3d"></div>
			</div>
		</div>

		<span class="resource timeValue" tooltip tooltip-translate="Duration">
					<i class="symbol_clock_small_flat_black duration"></i>{{building.data.rubbleDismantleTime|HHMMSS}}
				</span>
		<div class="dropOutBox"></div>

		<div class="boxDismantle">
			<div class="resources">
				<display-resources
					resources="building.data.rubble"
					signed="true"
					image-size="medium"
					color-positive="true"
					check-storage="true"></display-resources>
			</div>
		</div>
	</div>

	<div class="upgradeInfo dismantle" ng-class="{busy: busy}">
		<div class="actionText" ng-if="upgradeButtonClass == 'possible'">
			<span class="actionTextContent possible" translate>Dismantle.Tooltip.Possible</span>
		</div>
		<div class="actionText" ng-if="upgradeButtonClass == 'notNow'">
			<span class="actionTextContent notPossible" translate>Dismantle.Tooltip.NotPossible</span>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/displayResources.html"><div class="costs max{{Math.max((resources[0]+'').length,(resources[1]+'').length,(resources[2]+'').length,(resources[3]+'').length)}}digits">
	<span ng-if="!checkStorage">
		<span ng-repeat="(index, type) in resTypes" class="resource {{::type}}Value" ng-if="resourceVisibility[index]" ng-class="{notEnough: !enoughResources(index), enough: enoughResources(index) && colorPositive}" tooltip tooltip-translate="Resource_{{::index}}">
			<i class="unit_{{::type}}_{{::imageSize}}_illu resType{{index}}"></i>
			<span class="resourceValue" ng-class="::{strikethrough: showAsOldResources}">{{resources[index] | bidiNumber:numberUnit:resourceIsSigned:false}}</span>
			<span translate ng-if="::numberUnit=='production'">perHour</span>
		</span>
	</span>
	<span ng-if="checkStorage">
		<span ng-repeat="(index, type) in resTypes" class="resource {{::type}}Value" ng-if="resourceVisibility[index]" ng-class="{notEnough: !enoughStorage(index), enough: enoughStorage(index) && colorPositive}" tooltip tooltip-translate="Resource_{{::index}}">
			<i class="unit_{{::type}}_{{::imageSize}}_illu resType{{index}}"></i>
			<span class="resourceValue" ng-class="::{strikethrough: showAsOldResources}">{{resources[index] | bidiNumber:numberUnit:resourceIsSigned:false}}</span>
			<span translate ng-if="::numberUnit=='production'">perHour</span>
		</span>
	</span>

	<span class="resource consumptionValue" ng-if="showConsumption()" tooltip tooltip-translate="Resource.CropConsumption">
        <i class="unit_consumption_{{::imageSize}}_flat_black"></i>{{consumption | bidiNumber:'':true:true}}
    </span>
	<span class="resource populationValue" ng-if="showPopulation()" tooltip tooltip-translate="Resource.Population">
        <i class="unit_population_{{::imageSize}}_illu"></i>{{population | bidiNumber:'':true:true}}
    </span>

	<span class="resource treasureValue" ng-if="showTreasures()" tooltip tooltip-translate="Resource.Treasures">
        <i class="unit_treasure_{{::imageSize}}_illu"></i>{{treasures}}
    </span>

	<span class="resource treasureValue" ng-if="showStolenGoods()" tooltip tooltip-translate="Resource.StolenGoods">
        <i class="unit_stolenGoods_{{::imageSize}}_illu"></i>{{stolenGoods}}
    </span>

	<span class="resource timeValue" ng-if="showTime()" tooltip tooltip-translate="Duration">
        <i class="symbol_clock_{{::imageSize}}_flat_black duration"></i>{{time|HHMMSS}}
    </span>

	<div class="enoughResTime" ng-if="enoughResSecs == -1" translate>NeverEnoughRes</div>
	<div class="enoughResTime" ng-if="enoughResSecs > 0" translate data="time: {{enoughResSecs}}">EnoughResAt</div>
	<div class="enoughResTime" ng-if="capacityHint">{{capacityHint}}</div>

	<div class="iconButton premium npcTrade" ng-show="showNpc != undefined"><i class="feature_npcTrader_{{::imageSize}}_flat_black"></i></div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/upgradeActionInfo.html"><div class="upgradeInfo {{upgradeButtonClass}}" ng-class="{maxLevel: currentBuildingLevel >= building.data.lvlMax}">
	<div class="actionText" ng-if="!premiumOptionMenu.options.masterBuilder && upgradeButtonClass == 'possible' && currentBuildingLevel < building.data.lvlMax">
		<span class="actionTextContent possible" translate>Building.UpgradeCostsTooltip.Action.UpgradeInSlot</span>
	</div>
	<div class="actionText" ng-if="!premiumOptionMenu.options.masterBuilder && upgradeButtonClass == 'notAtAll' && currentBuildingLevel < building.data.lvlMax">
		<span class="actionTextContent notPossible" translate>Building.UpgradeCostsTooltip.Action.UpgradeNotPossible</span>
	</div>
	<div class="actionText" ng-if="premiumOptionMenu.options.masterBuilder == 'useMasterBuilder' && currentBuildingLevel < building.data.lvlMax">
		<span class="actionTextContent possibleNotPaid" translate>Building.UpgradeCostsTooltip.Action.AddToQueue</span>
	</div>
	<div class="actionText" ng-if="premiumOptionMenu.options.masterBuilder == 'buyMasterBuilder' && currentBuildingLevel < building.data.lvlMax">
		<span class="actionTextContent costsGold" translate>Building.UpgradeCostsTooltip.Action.UnlockSlot</span>
	</div>
	<div class="actionText" ng-if="premiumOptionMenu.options.masterBuilder == 'disabledMasterBuilder' && currentBuildingLevel < building.data.lvlMax">
		<span class="actionTextContent notPossible" translate>Building.UpgradeCostsTooltip.Action.QueueIsFull</span>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/upgradeCostsTooltip.html"><div class="upgradeCostsTooltip" ng-controller="buildingUpgradeTooltipCtrl">
	<div ng-include src="'tpl/building/partials/upgradeActionInfo.html'" class="upgradeInfoTop"></div>
	<div class="headline">
		<h3 translate class="building" options="{{building.data.buildingType}}">Building_?</h3>
	</div>

	<div class="queuedSlidesContainer">
		<div ng-repeat="numItem in [] | range:1:5" class="queuedBuildingSlide slide{{numItem}}" ng-class="{active: numItemsInQueue >= numItem, animate: originalSlides < numItem}"></div>
	</div>

	<div class="content" ng-class="{boxMaxLevel: building.data.lvl >= building.data.lvlMax, boxDeconstruction: upgradeButtonClass == 'demolish'}">
		<div class="contentTopArea">
			<div class="effectDescription" ng-if="building.data.currentEffect.values[0]">
				<span translate options="{{building.data.buildingType}}">Building.EffectDescriptionShort_0_?</span>
				<div class="horizontalLine3d" ng-if="building.data.currentEffect.values[0]"></div>
			</div>
			<table class="buildingNextEffects" ng-if="building.data.lvl < building.data.lvlMax && upgradeButtonClass != 'demolish'">
				<tbody>
					<tr>
						<td>
							<div class="buildingStatus">
								<div class="buildingBubble" ng-class="{disabled: upgradeButtonClass == 'notAtAll'}">
									<div class="colorLayer {{upgradeButtonClass == 'possible' && premiumOptionMenu.locationId == building.data.locationId ? 'notNow' : upgradeButtonClass}}"
										 ng-class="{disabled: upgradeButtonClass == 'notAtAll', enoughRes: enoughRes && freeMasterSlots > 0}">
										<div class="labelLayer">
											<span class="buildingLevel">{{currentBuildingLevel < building.data.lvlMax ? currentBuildingLevel : currentBuildingLevel - 1}}</span>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td class="borderLeft">
							<span class="resource populationValue" tooltip tooltip-translate="Resource.Population">
								<i class="unit_population_small_illu"></i>‎‭{{building.data.upgradeSupplyUsageSums[currentBuildingLevel - (currentBuildingLevel < building.data.lvlMax ? 0 : 1)]}}
							</span>
						</td>
						<td class="effectColumn">
							<span class="effectNumber" ng-if="building.data.currentEffect.values[0] || (building.data.effect && building.data.effect.length > 0)">
								<span translate options="{{building.data.buildingType}}"
										   data="value: {{building.data.effect[currentBuildingLevel - building.data.lvl - (currentBuildingLevel < building.data.lvlMax ? 0 : 1)]}}">
									Building.EffectValueShort_0_?</span>
							</span>
						</td>
						<td class="emptySpace"></td>
						<td class="effectColumn">
							<span class="effectNumber" ng-if="building.data.nextEffect.values[0]">
								<span translate options="{{building.data.buildingType}}"
										   data="value: {{building.data.effect[currentBuildingLevel - building.data.lvl + (currentBuildingLevel < building.data.lvlMax ? 1 : 0)]}}">
									Building.EffectValueShort_0_?</span>
							</span>
						</td>
						<td>
							<span class="resource populationValue" tooltip tooltip-translate="Resource.Population">
								<i class="unit_population_small_illu"></i>{{building.data.upgradeSupplyUsageSums[currentBuildingLevel + (currentBuildingLevel < building.data.lvlMax ? 1 : 0)]}}
							</span>
						</td>
						<td class="borderLeft">
							<div class="buildingStatus">
								<div class="buildingBubble" ng-class="{disabled: upgradeButtonClass == 'notAtAll'}">
									<div class="colorLayer {{currentBuildingLevel + 1 < building.data.lvlMax ? 'notNow' : 'maxLevel'}}"
										 ng-class="{disabled: upgradeButtonClass == 'notAtAll'}">
										<div class="labelLayer">
											<span class="buildingLevel">{{currentBuildingLevel < building.data.lvlMax ? currentBuildingLevel + 1 : currentBuildingLevel}}</span>
											<i ng-if="currentBuildingLevel + 1 >= building.data.lvlMax" class="symbol_star_tiny_illu ng-scope"></i>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="buildingNextEffects" ng-if="building.data.lvl >= building.data.lvlMax || upgradeButtonClass == 'demolish'">
				<tbody>
					<td>
						<span class="effectNumber" ng-if="building.data.currentEffect.values[0]">
							<span translate options="{{building.data.buildingType}}" data="value: {{building.data.currentEffect.values[0]}}">Building.EffectValueShort_0_?</span>
						</span>
					</td>
					<td>
						<span class="resource populationValue" tooltip tooltip-translate="Resource.Population">
							<i class="unit_population_small_illu"></i>‎‭{{building.data.upgradeSupplyUsageSums[currentBuildingLevel]}}
						</span>
					</td>
					<td class="borderLeft">
						<div class="buildingStatus">
							<div class="buildingBubble">
								<div class="colorLayer {{upgradeButtonClass == 'demolish' && building.data.lvl < building.data.lvlMax ? 'demolish' : 'maxLevel'}}">
									<div class="labelLayer">
										<span class="buildingLevel">{{currentBuildingLevel}}</span>
										<i ng-if="upgradeButtonClass == 'maxLevel' || building.data.lvl >= building.data.lvlMax" class="symbol_star_tiny_illu ng-scope"></i>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tbody>
			</table>
		</div>

		<span ng-if="currentBuildingLevel < building.data.lvlMax && upgradeButtonClass != 'demolish'" class="resource timeValue" tooltip tooltip-translate="Duration">
				<i class="symbol_clock_small_flat_black duration"></i>{{building.data.nextUpgradeTimes[currentBuildingLevel]|HHMMSS}}
			</span>
		<div ng-if="currentBuildingLevel < building.data.lvlMax && upgradeButtonClass != 'demolish'" class="dropOutBox"></div>

		<div class="resources" ng-if="currentBuildingLevel < building.data.lvlMax && upgradeButtonClass != 'demolish'">
			<display-resources available="storage"
				resources="building.data.nextUpgradeCosts[currentBuildingLevel]"
				image-size="medium">
			</display-resources>
		</div>
		<div class="description" ng-if="currentBuildingLevel >= building.data.lvlMax || upgradeButtonClass == 'demolish'"
			 ng-class="{maxLevel: currentBuildingLevel >= building.data.lvlMax}">
			<span ng-if="upgradeButtonClass != 'demolish' && building.data.lvl >= building.data.lvlMax" translate>Error.BuildingMaxLevel</span>
			<span ng-if="upgradeButtonClass != 'demolish' && building.data.lvl < building.data.lvlMax" translate>Building.UpgradeCostsTooltip.Info.UpgradeToMaxLevel</span>
			<span ng-if="upgradeButtonClass == 'demolish'" translate>Building.UpgradeCostsTooltip.Info.Deconstruction</span>
		</div>
	</div>
	<div ng-include src="'tpl/building/partials/upgradeActionInfo.html'" class="upgradeInfoBottom"></div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/upgradeMenuTooltip.html"><div class="upgradeMenuTooltip">
	<div ng-if="premiumOptionMenu.options.masterBuilder == 'useMasterBuilder'">
		<span translate>Building.UpgradeCostsTooltip.UseMasterBuilder</span>
		<div class="horizontalLine"></div>
		<display-resources ng-if="::(!enoughRes)" class="masterBuilderHint"
						   available="storage"
						   resources="building.data.upgradeCosts"
						   population="{{building.data.upgradeSupplyUsage}}"
						   time="{{building.data.upgradeTime}}"></display-resources>
		<span ng-if="::(!freeSlots)" class="masterBuilderHint" translate>Building.UpgradeCostsTooltip.BuildingQueueFull</span>
	</div>
	<div ng-if="::premiumOptionMenu.options.masterBuilder == 'buyMasterBuilder'">
		<display-resources ng-if="::(!enoughRes)"
						   available="storage"
						   resources="building.data.upgradeCosts"
						   population="{{building.data.upgradeSupplyUsage}}"
						   time="{{building.data.upgradeTime}}"></display-resources>
		<span ng-if="::(!freeSlots)" translate>Building.UpgradeCostsTooltip.BuildingQueueFull</span>
		<div class="horizontalLine"></div>
		<span class="masterBuilderHint" translate>Building.UpgradeCostsTooltip.BuyMasterBuilder</span>
	</div>
	<div ng-if="::premiumOptionMenu.options.masterBuilder == 'disabledMasterBuilder'">
		<span translate>Building.UpgradeCostsTooltip.UpgradeNotPossible</span>
		<div class="horizontalLine"></div>
		<span translate>Building.UpgradeCostsTooltip.WaitForCompletion</span>
		<display-resources available="storage"
						   resources="building.data.upgradeCosts"
						   population="{{building.data.upgradeSupplyUsage}}"
						   time="{{building.data.upgradeTime}}"></display-resources>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/partials/lists/celebrations.html"><div class="contentBox gradient celebrationsStart celebrationList">
	<div class="contentBoxBody">
		<carousel
			carousel-template="tpl/building/partials/lists/items/celebrationItem.html"
			carousel-items="celebrations"
			carousel-cols="celebrationsOptions.cols"
			carousel-active-item="activeItem"
			carousel-item-primary-key="type"
			carousel-window-height="w.maxWindowBodySizeObj.max">
		</carousel>
		<div class="celebrationBox contentBox gradient" ng-if="building.data.buildingType == buildingTypes.TOWN_HALL">
			<div class="contentBoxBody">
				<div class="celebrationLight" ng-class="{running: totalCelebrationCount > 0}">
					<span ng-if="totalCelebrationCount == 0" translate>TownHall.Celebration.isNotRunning</span>
					<span ng-if="totalCelebrationCount > 0" translate>TownHall.Celebration.isRunning</span>
				</div>
				<div class="horizontalLine"></div>
				<div class="infoBox">
					<span ng-if="totalCelebrationCount == 0 && !plusAccount" translate>TownHall.Celebration.Options</span>
					<span ng-if="totalCelebrationCount == 0 && plusAccount" translate>TownHall.Celebration.OptionsPlus</span>
					<table ng-if="totalCelebrationCount > 0" class="transparent">
						<tr>
							<th translate>TownHall.Celebration.Earning</th>
							<td>
								<i class="unit_culturePoint_small_illu" tooltip tooltip-translate="MainBuilding.CulturePoints"></i>
								{{currentCulturePointReward}}
							</td>
						</tr>
						<tr>
							<th translate>TownHall.Celebration.End</th>
							<td countdown="{{currentCelebrationEnd}}"></td>
						</tr>
						<tr ng-if="plusAccount">
							<td colspan="2" translate options="{{queuedCelebrationType || 0}}">TownHall.Celebration.Queue_?</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="contentBox gradient drinkHouseInfo" ng-if="building.data.buildingType != buildingTypes.TOWN_HALL">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content">
					<span translate>DrinkHouse.Infobox.Headline</span>
				</div>
			</h6>
			<div class="contentBoxBody">
				<table class="transparent">
					<tr class="currentBonus">
						<td><span translate>DrinkHouse.Infobox.CurrentBonus</span></td>
						<td>{{currentEffect.values[0]| bidiNumber:"percent"}}</td>
					</tr>
					<tr>
						<td><span translate options="{{building.data.buildingType}}" data="lvl: {{nextEffect.level}}">Building.LvlChangeDescription_?</span></td>
						<td>{{nextEffect.values[0]| bidiNumber:"percent"}}</td>
					</tr>
				</table>
				<div class="horizontalLine double"></div>
				<div class="chieftainMalus">
					<span translate>DrinkHouse.Infobox.ChieftainMalus</span>
					{{-50| bidiNumber:"percent"}}
				</div>
				<div class="randomTargetInfo" translate>DrinkHouse.Infobox.RandomTargetInfo</div>
			</div>
		</div>

		<div class="itemInfo">
			<table class="transparent" ng-if="building.data.buildingType == buildingTypes.TOWN_HALL">
				<tr>
					<th translate options="{{activeItem.type}}">TownHall.Celebration.Reward_?</th>
					<td>
						<i class="unit_culturePoint_small_illu" tooltip tooltip-translate="MainBuilding.CulturePoints"></i>
						<span class="reward">{{activeItem.culturePoints}}</span>
						<div class="symbol_i_tiny_wrapper">
							<i class="symbol_i_tiny_flat_white" tooltip tooltip-translate-switch="{
												'TownHall.Celebration.Tooltip.RewardSmall': {{activeItem.type == celebrationCfg.celebrationTypeSmall}},
												'TownHall.Celebration.Tooltip.RewardLarge': {{activeItem.type == celebrationCfg.celebrationTypeBig}} }"
							   tooltip-data="max:{{activeItem.type == celebrationCfg.celebrationTypeSmall ? celebrationCfg.celebrationCultureBonusSmall : celebrationCfg.celebrationCultureBonusBig}}"></i>
						</div>
					</td>
				</tr>
				<tr>
					<th translate>TownHall.Celebration.Duration</th>
					<td>{{activeItem.duration|HHMMSS}}</td>
				</tr>
				<tr>
					<th>
						<span translate>TownHall.Celebration.LoyaltyBonus</span>
						<div class="symbol_i_tiny_wrapper">
							<i class="symbol_i_tiny_flat_white" tooltip tooltip-translate="TownHall.Celebration.Tooltip.LoyaltyBonus"></i>
						</div>
					</th>
					<td>
						<span ng-if="activeItem.type == celebrationCfg.celebrationTypeSmall">-</span>
						<span ng-if="activeItem.type == celebrationCfg.celebrationTypeBig">
							{{celebrationCfg.celebrationLoyaltyBonusBig| bidiNumber:"percent"}}
							<span translate>TownHall.Celebration.LoyaltyBonusHint</span>
						</span>
					</td>
				</tr>
			</table>
			<span ng-if="building.data.buildingType != buildingTypes.TOWN_HALL">
				<h4 translate options="{{activeItem.type}}">celebrationTitle_?</h4>
				<div class="horizontalLine"></div>
				<div data="bonus:{{celebrationCfg.publicFestivalAttackPercentBonus}}" translate>DrinkHouse.Celebration.Description</div>
			</span>
		</div>
		<building-requirement ng-if="building.data.buildingType == buildingTypes.TOWN_HALL"
							  buildings="activeItem.requiredBuildings" other-requirements="activeItem.otherRequirements"></building-requirement>
		<display-resources class="costsFooter" resources="activeItem.costs" available="storage" ng-if="building.data.buildingType == buildingTypes.TOWN_HALL"></display-resources>
		<display-resources class="costsFooter" resources="activeItem.costs" time="{{activeItem.duration}}" available="storage" ng-if="building.data.buildingType != buildingTypes.TOWN_HALL"></display-resources>
	</div>
</div>

<button ng-class="{disabled: celebrationQueueFull || !activeItem || activeItem.disabled || !hasEnoughResources(activeItem.costs)}"
		class="footerButton"
		clickable="startCelebration(activeItem)"
		tooltip
		tooltip-translate-switch="{
			'TownHall.Celebration.QueueFull': {{celebrationQueueFull == true}},
			'Academy.NothingSelected': {{!activeItem}},
			'TownHall.Celebration.UpgradeTownHall': {{activeItem.disabled == true && w.building.data.lvl < celebrationCfg.villageCountForBigCelebration}},
			'TownHall.Celebration.VillagesRequired': {{activeItem.disabled == true && w.building.data.lvl >= celebrationCfg.villageCountForBigCelebration}},
			'Error.NotEnoughRes': {{!hasEnoughResources(activeItem.costs)}} }">
<span translate>Button.Celebration</span>
</button>

<npc-trader-button class="footerButton" type="celebration" use-npc="{{!hasEnoughResources(activeItem.costs)}}" costs="{{activeItem.costs}}"></npc-trader-button>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/traps.html"><div class="contentBox trapsBuild unitList">
	<div class="contentBoxBody">
		<carousel
			carousel-template="tpl/building/partials/lists/items/trapItem.html"
			carousel-items="[traps]"
			carousel-cols="1"
			carousel-active-item="activeItem"
			carousel-item-primary-key="unitType"
			carousel-window-height="w.maxWindowBodySizeObj.max">
		</carousel>
		<div class="trapsOverview contentBox gradient">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content" translate>Trapper.Info</div>
			</h6>
			<div class="contentBoxBody">
				<table class="transparent">
					<tbody>
						<tr>
							<th><span translate>Trapper.CurrentAmount</span></th>
							<th>{{activeItem.total+activeItem.queueTotal}}</th>
						</tr>
						<tr>
							<td><span translate>Trapper.UsedTraps</span></td>
							<td>{{-1*activeItem.used}}</td>
						</tr>
						<tr>
							<td><span translate>Trapper.UnderConstruction</span></td>
							<td>{{-1*activeItem.queueTotal}}</td>
						</tr>
						<tr>
							<td><span translate>Trapper.FreeTraps</span></td>
							<td>{{activeItem.total-activeItem.used}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="itemInfo">
			<span data="used:{{activeItem.total+activeItem.queueTotal}},total:{{activeItem.maxByBuildingLevel}}" translate>Trapper.currentTraps</span>

			<div class="horizontalLine"></div>
			<div ng-if="activeItem.used > 0" translate>Trapper.Captives</div>
			<div ng-if="activeItem.used == 0" translate>Trapper.NoCaptives</div>
		</div>
		<display-resources class="costsFooter" resources="activeItem.allCosts" time="{{activeItem.allTime}}" available="storage"></display-resources>
		<div class="sliderRow" ng-if="activeItem">
			<div class="sliderArrow"></div>
			<slider ng-if="activeItem.maxAvailable <= 0" slider-min="1" slider-max="1" slider-data="activeItem" slider-changed="sliderChanged"></slider>
			<slider ng-if="activeItem.maxAvailable > 0" slider-min="1" slider-max="activeItem.maxAvailable" slider-data="activeItem" slider-changed="sliderChanged"></slider>
			<npc-trader-button type="unitTrain" costs="{{activeItem.costs}}"
							   current-max="{{activeItem.maxAvailable}}" current-limit="{{(activeItem.maxByBuildingLevel - activeItem.total - activeItem.queueTotal)}}">
			</npc-trader-button>
		</div>
	</div>
</div>

<button ng-class="{disabled: (activeItem.value <= 0) || (!hasEnoughResources(activeItem.costs)) || ((activeItem.total + activeItem.queueTotal) >= activeItem.maxByBuildingLevel) }"
		class="footerButton"
		clickable="startTraining()"
		tooltip
		tooltip-translate-switch="{
			'TrainTroops.SetAmount': {{activeItem.value <= 0}},
			'Error.NotEnoughRes': {{!hasEnoughResources(activeItem.costs)}},
			'Trapper.MaxDueToLevelReached': {{(activeItem.total + activeItem.queueTotal) >= activeItem.maxByBuildingLevel}}
			}">
	<span translate>Button.Build</span>
</button>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/units.html"><div class="contentBox gradient unitList">
	<div class="contentBoxBody">
		<carousel
			carousel-template="{{building.data.buildingType == buildingTypes.ACADEMY ? 'tpl/building/partials/lists/items/unitResearchItem.html' :
								 building.data.buildingType == buildingTypes.BLACKSMITH ? 'tpl/building/partials/lists/items/unitUpgradeItem.html' :
								 'tpl/building/partials/lists/items/unitTrainItem.html'}}"
			carousel-items="units"
			carousel-active-item="$parent.activeItem"
			carousel-window-height="w.maxWindowBodySizeObj.max"
			carousel-cols="unitsTrainOptions.cols"
			carousel-item-primary-key="unitType"
			carousel-callback="produceFirst">
		</carousel>

		<table class="unitInfo transparent" ng-if="activeItem">
			<tbody>
				<tr>
					<td>
						<div class="unitHeader">
							<span unit-icon class="unitIcon" big="true" data="{{activeItem.unitType}}"></span>
							<h4 class="unitName">
								<span translate options="{{activeItem.unitType}}">Troop_?</span>
								<span class="level" ng-if="activeItem.unitLevel >= 0 &&
									!(building.data.buildingType == buildingTypes.PALACE || building.data.buildingType == buildingTypes.RESIDENCE)">
									<span translate>Units.Research.Level</span> {{activeItem.unitLevel}}
									<span ng-if="building.data.buildingType == buildingTypes.BLACKSMITH" class="levelText">/{{building.data.lvl}}</span>
								</span>
								<span ng-if="building.data.buildingType == buildingTypes.PALACE || building.data.buildingType == buildingTypes.RESIDENCE">
									<span ng-if="activeItem.existing">({{activeItem.existing}})</span>
									<span class="notEnoughSlots" ng-if="usedControlPoint >= availableControlPoints || (activeItem.unitType == leaderId && (availableControlPoints - usedControlPoint) < 3)">
										<span>(<span translate>ExpansionSlots.ExpansionList.NotEnoughSlots</span>)</span>
									</span>
								</span>
							</h4>
							<div class="symbol_i_medium_wrapper">
								<i class="symbol_i_medium_flat_white" clickable="openWindow('help', {'pageId': 'Troops_' + activeItem.unitType})"
							   tooltip tooltip-translate="Units.Tooltip.UnitInfo" tooltip-placement="above"></i>
							</div>
						</div>
						<div class="description" translate options="{{activeItem.unitType}}">Troop.Description_?</div>

					</td>
					<td>
						<table class="unitAttributes transparent">
							<tbody>
								<tr>
									<td>
										<i class="unit_capacity_small_flat_black" tooltip tooltip-translate="Troops.CarryingCapacity.Label"></i>
									</td>
									<td>{{activeItem.troopData.carry}}</td>
								</tr>
								<tr>
									<td><i class="unit_speed_small_flat_black" tooltip tooltip-translate="Troops.Speed.Label"></i></td>
									<td>{{activeItem.troopData.speed}}</td>
								</tr>
								<tr>
									<td>
										<i class="unit_consumption_small_flat_black" tooltip tooltip-translate="Troops.CropConsumption.Label"></i>
									</td>
									<td>{{activeItem.troopData.supply}}</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td>
						<table class="unitAttributes transparent" ng-if="building.data.buildingType != buildingTypes.BLACKSMITH">
							<tbody>
								<tr>
									<td><i class="movement_attack_small_flat_black" tooltip tooltip-translate="TroopAttribute.Attack"></i>
									</td>
									<td>{{activeItem.currentStrength.attack}}</td>
								</tr>
								<tr>
									<td>
										<i class="unit_defenseInfantry_small_flat_black" tooltip tooltip-translate="TroopAttribute.DefenseInfantry"></i>
									</td>
									<td>{{activeItem.currentStrength.defence}}</td>
								</tr>
								<tr>
									<td>
										<i class="unit_defenseCavalry_small_flat_black" tooltip tooltip-translate="TroopAttribute.DefenseCavalry"></i>
									</td>
									<td>{{activeItem.currentStrength.defenceCavalry}}</td>
								</tr>
							</tbody>
						</table>
						<table class="unitAttributes transparent" ng-if="building.data.buildingType == buildingTypes.BLACKSMITH">
							<tbody>
								<tr tooltip
									tooltip-placement="above"
									tooltip-url="tpl/building/partials/lists/items/unitUpgradeTooltip.html"
									tooltip-data="type:attack">
									<td><i class="movement_attack_small_flat_black"></i></td>
									<td>{{activeItem.currentStrength.attack}}</td>
								</tr>
								<tr tooltip
									tooltip-placement="above"
									tooltip-url="tpl/building/partials/lists/items/unitUpgradeTooltip.html"
									tooltip-data="type:defence">
									<td><i class="unit_defenseInfantry_small_flat_black"></i></td>
									<td>{{activeItem.currentStrength.defence}}</td>
								</tr>
								<tr tooltip
									tooltip-placement="above"
									tooltip-url="tpl/building/partials/lists/items/unitUpgradeTooltip.html"
									tooltip-data="type:defenceCavalry">
									<td><i class="unit_defenseCavalry_small_flat_black"></i></td>
									<td>{{activeItem.currentStrength.defenceCavalry}}</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<building-requirement ng-if="activeItem.required.length > 0" buildings="activeItem.required"></building-requirement>
		<div class="horizontalLine" ng-if="!activeItem.required || activeItem.required.length == 0"></div>
		<display-resources ng-if="activeItem" class="costsFooter" resources="allCosts || activeItem.costs" hide-zero="true" available="storage"
						   consumption="{{activeItem.troopData.supply*allValue || 0}}" time="{{allTime || activeItem.time}}">
		</display-resources>
		<span ng-if="building.data.buildingType == buildingTypes.ACADEMY && !activeItem" class="allResearched" translate>Units.Research.AllResearched</span>

		<div class="sliderRow" ng-if="building.data.buildingType != buildingTypes.ACADEMY && building.data.buildingType != buildingTypes.BLACKSMITH">
			<div class="sliderArrow"></div>
			<slider ng-if="!activeItem.maxAvailable || activeItem.maxAvailable <= 0"
					slider-min="1"
					slider-max="1"
					slider-changed="sliderChanged"
					input-autofocus="true"></slider>
			<slider ng-if="activeItem.maxAvailable > 0"
					slider-min="1"
					slider-max="activeItem.maxAvailable"
					slider-changed="sliderChanged"
					input-autofocus="true"></slider>
			<npc-trader-button ng-if="building.data.buildingType != buildingTypes.PALACE && building.data.buildingType != buildingTypes.RESIDENCE"
							   type="unitTrain"
							   costs="{{activeItem.costs}}"
							   current-max="{{activeItem.maxAvailable}}">
			</npc-trader-button>
			<npc-trader-button ng-if="building.data.buildingType == buildingTypes.PALACE || building.data.buildingType == buildingTypes.RESIDENCE"
							   type="unitTrain"
							   costs="{{activeItem.costs}}"
							   current-max="{{activeItem.maxAvailable}}"
							   current-limit="{{(availableControlPoints - usedControlPoint)/(activeItem.unitType == leaderId ? 3:1)}}">
			</npc-trader-button>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/items/celebrationItem.html"><div class="orderItem item celebration" ng-show="item">
	<div class="clickableContainer"
		 clickable="carousel.setActiveItem(item)"
		 ng-class="{active: carouselActiveItem.type === item.type}"
		 play-on-click="{{$root.UISound.BUTTON_SQUARE_CLICK}}">
		<img src="layout/images/x.gif" class="itemImage celebration"
			 ng-class="{celebration_small_illu: item.type == 1,
			 			celebration_large_illu: item.type == 2,
			 			celebration_brewery_illu: item.type == 3 && !item.isTeaHouse,
			 			celebration_teahouse_illu: item.type == 3 && item.isTeaHouse}">

		<div class="itemHead">
			<span translate options="{{item.type}}">celebrationTitle_?</span>
		</div>
		<div class="horizontalLine double">
			<h6 class="headerTrapezoidal bright" ng-if="item.disabled === false">
				<div class="content">
					<i class="unit_culturePoint_small_flat_black" tooltip tooltip-translate="MainBuilding.CulturePoints"></i>
					{{item.culturePoints}}
				</div>
			</h6>
		</div>
		<div class="itemBody">
			<div class="symbol_lock_medium_wrapper" ng-if="item.disabled !== false">
				<i class="symbol_lock_medium_flat_black"></i>
			</div>
			<div class="lockExplain" ng-if="item.disabled !== false">
				<div class="content">
					<span translate data="level:{{$root.config.balancing.celebrationConfig.firstLevelOfTownHallForBigCelebration}}" options="{{item.disabled}}">LockedReason.BigCelebration_?</span>
				</div>
			</div>
			<div class="progressContainer" ng-if="item.queue.count">
				<div class="queueAmount">{{item.queue.count}}</div>
				<div progressbar finish-time="{{item.queue.timeFinishedLast}}"
							 finish-time-total="{{item.queue.timeFinishedLast}}"
							 duration="{{item.duration * item.queue.count}}"
							 show-countdown="true"
							 tooltip tooltip-translate="CelebrationEndTime" tooltip-data="time:{{item.queue.timeFinishedFirst}}"></div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/items/trapItem.html"><div class="orderItem item trap" ng-show="item">
	<div class="clickableContainer" clickable="carousel.setActiveItem(item)" ng-class="{active: carouselActiveItem.type === item.type}">
		<img class="feature_trap_huge_illu itemImage" src="layout/images/x.gif" />
		<div class="itemHead">
			<span translate>Trap</span>
		</div>
		<div class="horizontalLine"></div>
		<div class="itemBody">
			<div class="symbol_lock_medium_wrapper" ng-if="item.maxByBuildingLevel-item.total-item.queueTotal <= 0">
				<i class="symbol_lock_medium_flat_black"></i>
			</div>
			<div class="lockExplain" ng-if="item.maxByBuildingLevel-item.total-item.queueTotal <= 0">
				<div class="content"><span translate>LockedReason.TrapMaximum</span></div>
			</div>
			<div class="progressContainer" ng-if="item.queue.count">
				<div class="queueAmount"><div class="amount">{{item.queue.count}}</div></div>
				<div progressbar finish-time="{{item.queue.timeFinishedNext}}"
							 finish-time-total="{{item.queue.timeFinishedLast}}"
							 duration="{{item.queue.durationPerUnit}}"
							 show-countdown="true"
							 tooltip tooltip-translate="Units.Build.Tooltip.unitTime" tooltip-data="time:{{item.queue.timeFinishedNext}}"></div>
				<div class="additionalInfo" ng-show="!item.disabled">
					<i class="action_setMax_tiny_flat_black"></i>
					<span>{{item.maxAvailable}}</span>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/items/unitResearchItem.html"><div class="item unit research" ng-show="item">
	<div class="clickableContainer"
		 clickable="carousel.setActiveItem(item)"
		 ng-class="{active: carouselActiveItem.unitType === item.unitType}"
		 play-on-click="{{$root.UISound.BUTTON_SQUARE_CLICK}}">
		<unit-image data="{{item.unitType}}" size="thumb" class="itemImage"></unit-image>
		<div class="itemHead">
			<span translate options="{{item.unitType}}">Troop_?</span>
		</div>
		<div class="horizontalLine double"></div>
		<div class="itemBody">
			<div class="symbol_lock_medium_wrapper" ng-if="item.canResearch !== true">
				<i class="symbol_lock_medium_flat_black"></i>
			</div>
			<div class="lockExplain" ng-if="item.canResearch !== true">
				<div class="content"><span translate>LockedReason.UnitResearch</span></div>
			</div>
			<div class="progressContainer" ng-if="item.queue">
				<div progressbar finish-time="{{item.queue[0].finished}}"
							 finish-time-total="{{item.queue[0].finished}}"
							 duration="{{item.queue[0].finished - item.queue[0].startTime}}"
							 show-countdown="true"></div>
			</div>
		</div>
	</div>
</div>
<div class="item dummy" ng-show="!item"></div>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/items/unitTrainItem.html"><div class="item unit train" ng-show="item">
	<div class="clickableContainer"
		 clickable="carousel.setActiveItem(item)"
		 ng-class="{active: carouselActiveItem.unitType === item.unitType}"
		 play-on-click="{{$root.UISound.BUTTON_SQUARE_CLICK}}">
		<unit-image data="{{item.unitType}}" size="thumb" class="itemImage"></unit-image>
		<div class="itemHead">
			<span translate options="{{item.unitType}}">Troop_?</span>
		</div>
		<div class="horizontalLine double"></div>
		<div class="makeFirst" clickable="carouselCallback(item)"
			 ng-if="item.queue && item.queue.key > 0 && carouselActiveItem.unitType === item.unitType"
			 tooltip tooltip-translate="Troop.MoveInQueue.Tooltip">
			<div class="moveLabel" translate>Troop.MoveInQueue</div>
			<div class="moveArrow">
				<div class="doubleArrow"></div>
			</div>
		</div>
		<div class="itemBody">
			<div class="symbol_lock_medium_wrapper" ng-if="item.disabled === true">
				<i class="symbol_{{item.disabledIcon}}_medium_flat_black"></i>
			</div>
			<div class="lockExplain" ng-if="item.disabled === true">
				<div class="content"><span translate options="{{item.disabledIcon}}">LockedReason.UnitTrain_?</span></div>
			</div>
			<div class="progressContainer" ng-if="item.queue.count > 0">
				<div class="queueAmount" ng-show="item.queue.count > 0"><div class="amount">{{item.queue.count}}</div></div>
				<div progressbar finish-time="{{item.queue.timeFinishedNext}}"
							 finish-time-total="{{item.queue.timeFinishedLast}}"
							 duration="{{item.queue.durationPerUnit}}"
							 show-countdown="true"
							 tooltip tooltip-placement="above" tooltip-translate="Units.Build.Tooltip.unitTime" tooltip-data="time:{{item.queue.timeFinishedNext}}"></div>
				<div class="additionalInfo" ng-show="!item.disabled">
					<i class="action_setMax_tiny_flat_black"></i>
					<span>{{item.maxAvailable}}</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="item dummy" ng-show="!item"></div>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/items/unitUpgradeItem.html"><div class="item unit upgrade" ng-show="item">
	<div class="clickableContainer"
		 clickable="carousel.setActiveItem(item)"
		 ng-class="{active: carouselActiveItem.unitType === item.unitType}"
		 play-on-click="{{$root.UISound.BUTTON_SQUARE_CLICK}}">
		<unit-image data="{{item.unitType}}" size="thumb" class="itemImage"></unit-image>
		<div class="itemHead">
			<span translate options="{{item.unitType}}">Troop_?</span>
		</div>
		<div class="horizontalLine double"></div>
		<div class="itemBody">
			<div class="symbol_lock_medium_wrapper" ng-if="item.canUpgrade !== true && !item.queue">
				<i class="symbol_{{item.disabledIcon}}_medium_flat_black"></i>
			</div>
			<div class="lockExplain" ng-if="item.canUpgrade !== true && !item.queue">
				<div class="content"><span translate options="{{item.disabledIcon}}">LockedReason.UnitUpgrade_?</span></div>
			</div>
			<div class="progressContainer" ng-show="item.queue">
				<div class="queueAmount">{{item.queue.length | bidiNumber:'':true:true}}</div>
				<div progressbar finish-time="{{item.queue[0].finished}}"
							 finish-time-total="{{item.queue[item.queue.length-1].finished}}"
							 duration="{{item.queue[0].finished - item.queue[0].startTime}}"
							 show-countdown="true"
							 tooltip tooltip-translate="Units.Research.Tooltip.unitTime" tooltip-data="time:{{item.queue[0].finished}}"></div>
				<div class="additionalInfo">
					<span translate>Units.Research.Level</span> <span>{{item.unitLevel}}</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="item dummy" ng-show="!item"></div>
</script>
<script type="text/ng-template" id="tpl/building/partials/lists/items/unitUpgradeTooltip.html"><table ng-if="activeItem.researchStrength.length > 0">
	<tr>
		<td>
			<span translate>Units.Tooltip.CurrentLevel</span>
		</td>
		<td>
			<span ng-if="type == 'attack'">{{activeItem.currentStrength.attack}}</span>
			<span ng-if="type == 'defence'">{{activeItem.currentStrength.defence}}</span>
			<span ng-if="type == 'defenceCavalry'">{{activeItem.currentStrength.defenceCavalry}}</span>
		</td>
	</tr>
	<tbody>
		<tr>
			<td colspan="2">
				<span translate>Units.Tooltip.NextLevels</span>:
			</td>
		</tr>
		<tr ng-repeat="lvl in activeItem.researchStrength | orderBy:'level'">
			<td>
				<span translate>Units.Tooltip.Lvl</span> {{lvl.level}}
			</td>
			<td>
				<span ng-if="type == 'attack'">{{lvl.attack}}</span>
				<span ng-if="type == 'defence'">{{lvl.defence}}</span>
				<span ng-if="type == 'defenceCavalry'">{{lvl.defenceCavalry}}</span>
			</td>
		</tr>
	</tbody>
</table>

<div translate ng-if="activeItem.researchStrength.length <= 0">
	Units.Tooltip.MaxLevel
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/rallypoint_main.html"><div class="buildingDetails rallypoint" ng-controller="rallypointCtrl">
	<div ng-show="isBuildingBuild()">
        <div ng-include="tabBody"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/CombatSimulator.html"><div class="combatSimulator" ng-controller="combatSimulatorCtrl">
<table class="optionTable transparent">
	<tbody>
	<tr>
		<td translate>CombatSimulator.AttackType</td>
		<td>
			<label>
				<input type="radio" ng-model="attackType" ng-value="Troops.MOVEMENT_TYPE_ATTACK">
				<span translate>Offense</span>
			</label>
		</td>
		<td>
			<label>
				<input type="radio" ng-model="attackType" ng-value="Troops.MOVEMENT_TYPE_RAID">
				<span translate>Raid</span>
			</label>
		</td>
		<td>
			<label tooltip tooltip-translate="RallyPoint.SendTroops.Type_Siege">
				<input type="radio" ng-model="$parent.attackType" ng-value="Troops.MOVEMENT_TYPE_SIEGE"
					   ng-disabled="attackerUnitCount < 1000 || !attackerDetails.inputTroops[Troops.TYPE_RAM]">
				<span translate>Siege</span>
			</label>
		</td>
		<td class="gapCol"></td>
		<td translate>CombatSimulator.ExtendedMode</td>
		<td>
			<div class="switchContainer">
				<switch switch-name1="No" switch-name2="Yes" switch-callback="switchCallback" switch-model="extendedMode"></switch>
			</div>
		</td>
	</tr>
	</tbody>
</table>

<!-- Attacker -->

<div class="troopsDetailContainer attacker">
	<div class="troopsDetailHeader fromHeader">
		<i class="attack colorIcon"></i>
		<span translate>Attacker</span>
		<div class="troopsInfo">
			<div dropdown data="attackerDetails.tribeDropdown" open-downwards="true">{{option.name}}</div>
		</div>
	</div>
	<div class="villageSettings" ng-if="extendedMode">
		<div ng-repeat="(n, setting) in ['population', 'target1', 'target2', 'natarBonus']" class="{{setting}}InputContainer"
			 ng-if="setting!='natarBonus' || (attackerDetails.inputTroops[Troops.TYPE_HERO] && defenderDetails[0].tribeId == Player.TRIBE.NATAR)">
			<i ng-if="setting=='population'"
			   class="unit_population_small_flat_black"
			   tooltip tooltip-translate="Population"></i>
			<i ng-if="setting=='natarBonus'"
			   class="feature_natars_small_flat_black"
			   tooltip tooltip-translate="CombatSimulator.NatarBonus"></i>
			<i ng-if="setting=='target1'||setting=='target2'"
			   class="symbol_target_small_flat_black"
			   tooltip tooltip-translate="CombatSimulator.catapultTarget_{{n}}"></i>
			<input ng-model="attackerDetails.villageSettings[setting]" number="{{::$first || $last ? $last ? 50: 99999 : 100}}"
				   ng-disabled="setting=='target2' && (!attackerDetails.villageSettings['target1'] || !attackerDetails.inputTroops[Troops.TYPE_CATAPULT] ||
				   				attackerDetails.inputTroops[Troops.TYPE_CATAPULT] < Troops.SECOND_TARGET_CATAPULTS)"/>
		</div>
	</div>
	<table class="troopsTable transparent" ng-if="extendedMode">
		<tbody class="levelInput">
		<tr>
			<td ng-repeat="n in [] | range:1:9" tooltip tooltip-translate="CombatSimulator.unitLevel">
				<input ng-model="attackerDetails.unitLevels[n]" number="{{Troops.MAX_LEVEL}}" hide-zero="true" type="tel"
					   ng-disabled="!attackerDetails.inputTroops[n] || attackerDetails.inputTroops[n] == 0"/>
			</td>
			<td colspan="2"></td>
		</tr>
		</tbody>
	</table>
	<div troops-details troop-data="attackerDetails" ng-class="{losses: attackerDetails.lostTroops || attackerDetails.heroHealthLoss}"
					unit-input-callback="checkHero" unit-icon-callback="setVillageUnits"></div>
	<div class="heroOptionsContainer" ng-if="attackerDetails.inputTroops[Troops.TYPE_HERO]">
		<span><span translate>Troop_hero</span>:</span>
		<div class="unitBonusContainer">
			<i class="symbol_increaseArrow_tiny_flat_white"></i>
		</div>
		<div dropdown data="attackerDetails.equipmentDropdown" open-downwards="true">{{option.name}}</div>
			<span class="heroInput" tooltip tooltip-translate="CombatSimulator.Mounted">
				<i class="item_category_horse_small_flat_black"></i>
				<input ng-model="attackerDetails.mounted" type="checkbox"/>
			</span>
			<span class="heroInput" tooltip tooltip-translate="CombatSimulator.heroFightStrength">
				<i class="attribute_strength_small_flat_black"></i>
				<input number="99999" ng-model="attackerDetails.heroStrength" type="tel"/>
			</span>
			<span class="heroInput" tooltip tooltip-translate="CombatSimulator.heroOffBonus">
				<i class="attribute_offense_small_flat_black"></i>
				<input number="9999" ng-model="attackerDetails.heroBonus" float="1" type="tel"/>
			</span>

	</div>
</div>
<div class="separatorArrow"></div>

<!-- Defenders -->

<div class="troopsDetailContainer defenders">
	<div ng-repeat="troopDetails in defenderDetails">
		<div class="troopsDetailHeader toHeader">
			<i class="defend colorIcon"></i>
			<span translate ng-if="$first">Defender</span>
			<span translate ng-if="!$first">Support</span>
			<div class="troopsInfo">
					<span ng-if="$first" class="addSupport">
						<span translate>CombatSimulator.addSupport</span>
						<a class="iconButton doubleBorder" clickable="addSupport()">
							<i class="symbol_plus_tiny_flat_black"></i>
						</a>
					</span>
					<span ng-if="!$first" class="addSupport">
						<a class="iconButton doubleBorder" clickable="deleteSupport($index)">
							<i class="symbol_minus_tiny_flat_black"></i>
						</a>
					</span>
				<div dropdown data="troopDetails.tribeDropdown" open-downwards="true">{{option.name}}</div>
			</div>
		</div>
		<div class="villageSettings" ng-if="$first && extendedMode && troopDetails.tribeId != Player.TRIBE.NATURE">
			<div ng-repeat="setting in ['population', 'mason', 'wall', 'palace', 'moat']">
				<i ng-if="$first" class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i>
				<i ng-if="!$first"
				   ng-class="{
				   		building_g34_small_flat_black: setting == 'mason',
				   		building_g31_small_flat_black: setting == 'wall',
				   		building_g25_small_flat_black: setting == 'palace',
				   		building_g42_small_flat_black: setting == 'moat'
				   }"
				   tooltip tooltip-translate="{{'CombatSimulator.'+setting+'Level'}}"></i>
				<input ng-model="troopDetails.villageSettings[setting]" number="{{$first ? 99999 : Building.MAX_LEVEL}}" />
			</div>
		</div>
		<table class="troopsTable transparent" ng-if="extendedMode && troopDetails.tribeId < Player.TRIBE.NATURE">
			<tbody class="levelInput">
			<tr>
					<td ng-repeat="n in [] | range:1:9" tooltip tooltip-translate="CombatSimulator.unitLevel">
						<input ng-model="troopDetails.unitLevels[n]" number="{{Troops.MAX_LEVEL}}" hide-zero="true"
							   ng-disabled="!troopDetails.inputTroops[n] || troopDetails.inputTroops[n] == 0"/>
					</td>
					<td colspan="2"></td>
				</tr>
			</tbody>
		</table>
		<div troops-details troop-data="troopDetails" ng-class="{losses: troopDetails.lostTroops || troopDetails.heroHealthLoss}"
						unit-input-callback="checkHero" unit-icon-callback="setVillageUnits"></div>
		<div class="heroOptionsContainer" ng-if="troopDetails.inputTroops[Troops.TYPE_HERO]">
			<span><span translate>Troop_hero</span>:</span>
			<div class="unitBonusContainer">
				<i class="symbol_increaseArrow_tiny_flat_white"></i>
			</div>
			<div dropdown data="troopDetails.equipmentDropdown" open-downwards="true">{{option.name}}</div>
				<span class="heroInput" tooltip tooltip-translate="CombatSimulator.Mounted">
					<i class="item_category_horse_small_flat_black"></i>
					<input ng-model="troopDetails.mounted" type="checkbox"/>
				</span>
				<span class="heroInput" tooltip tooltip-translate="CombatSimulator.heroFightStrength">
					<i class="attribute_strength_small_flat_black"></i>
					<input number="99999" ng-model="troopDetails.heroStrength" />
				</span>
				<span class="heroInput" tooltip tooltip-translate="CombatSimulator.heroDefBonus">
					<i class="attribute_defense_small_flat_black"></i>
					<input number="9999" ng-model="troopDetails.heroBonus" float="1" />
				</span>
		</div>
	</div>
</div>

<!-- Result -->

<div class="separatorArrow" ng-if="result"></div>
<div class="resultContainer contentBox gradient" ng-if="result">
	<div class="contentBoxBody">
		<table class="transparent">
			<tbody>
			<tr>
				<td>
					<span translate>CombatSimulator.Losses</span>
				</td>
				<td>
					<i class="reportIcon colorIcon reportIcon{{result.successType.attacker}}"></i>
					<span translate>Attacker</span>:
					{{result.lossPercent.attacker | bidiNumber:"percent"}}
				</td>
				<td>
					<i class="reportIcon colorIcon reportIcon{{result.successType.defender}}"></i>
					<span translate>Defender</span>:
					{{result.lossPercent.defender | bidiNumber:"percent"}}
				</td>
			</tr>
			</tbody>
		</table>
		<div class="wallDamage" ng-if="result.wallDamage">
			<!--<img buildingSmall buildingType ng-src="layout/images/old/maps/village/buildings/small/{{result.wallDamage.imageName}}.png"-->
				 <!--tooltip tooltip-translate="CombatSimulator.wallDamage"/>-->
			<i class="buildingLarge buildingType{{result.wallDamage.buildingType}} tribeId{{result.wallDamage.tribeId}}"></i>
			<span class="finalLevel">{{result.wallDamage.finalLevel}}</span>
		</div>
		<div ng-repeat="(id, lvl) in result.buildingDamage track by id" ng-if="extendedMode && (lvl||lvl==0)" class="buildingDamage">
			<span translate data="buildingFinalLevel:{{lvl}}" options="{{id}}">CombatSimulator.buildingDamage_?</span>
		</div>
	</div>
</div>
<table class="statisticsTable transparent" ng-if="result && extendedMode">
	<tbody>
	<tr>
		<th translate>CombatSimulator.Result</th>
		<th><i class="attack colorIcon"></i></th>
		<th><i class="defend colorIcon"></i></th>
	</tr>
	<tr>
		<th translate>CombatSimulator.Statistics.Caption_strength</th>
		<td colspan="2">
			<div class="resultBar">
				<span>{{result.totalEffective.attacker}}</span>

					<div class="divider" ng-style="{width: ((result.totalEffective.attacker*100)/(result.totalEffective.attacker+result.totalEffective.defender))+'%'}"></div>
					<span>{{result.totalEffective.defender}}</span>
				</div>
			</td>
		</tr>
		<tr class="captionRow">
			<th translate>CombatSimulator.Statistics.LostUnits</th>
			<td colspan="2"></td>
		</tr>
		<tr ng-repeat="(key, statistic) in result.losses">
			<th translate options="{{key}}">CombatSimulator.Statistics.Caption_?</th>
			<td colspan="2">
				<div class="resultBar">
					<span ng-if="key != 'time'">{{statistic.attacker}}</span>
					<span ng-if="key == 'time'">{{statistic.attacker | HHMMSS}}</span>

					<div class="divider" ng-style="{width: ((statistic.attacker*100)/(statistic.attacker+statistic.defender))+'%'}"></div>
					<span ng-if="key != 'time'">{{statistic.defender}}</span>
					<span ng-if="key == 'time'">{{statistic.defender | HHMMSS}}</span>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<button clickable="simulate()"
		ng-class="{disabled: !attackerUnitCount || ($parent.attackType == Troops.MOVEMENT_TYPE_SIEGE && (attackerUnitCount < 1000 || !attackerDetails.inputTroops[Troops.TYPE_RAM]))}"
		tooltip tooltip-translate="RallyPoint.SendTroops.Type_Siege" tooltip-hide="{{!($parent.attackType == Troops.MOVEMENT_TYPE_SIEGE && (attackerUnitCount < 1000 || !attackerDetails.inputTroops[Troops.TYPE_RAM]))}}">
	<span translate>CombatSimulator.simulate</span>
</button>
<button clickable="applyLosses()" ng-if="result" ng-class="{disabled: !enableApplyLosses}">
	<span translate>CombatSimulator.applyLosses</span>
</button>
</div>
</script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/FarmList.html"><div class="farmList" ng-controller="farmListCtrl">
<div ng-if="hasNoobProtection" translate>
FarmList.StillInNoobProtection
	</div>
	<div ng-if="!hasNoobProtection">
		<div class="listOverview" ng-if="currentListIndex < 0">
			<div class="contentBox gradient">
				<h6 class="contentBoxHeader headerTrapezoidal marginToScrollbar">
					<div class="content">
						<span translate>FarmList.ListOverview.Title</span>
					</div>
					<div class="newFarmList">
						<span translate>FarmList.ListOverview.NewFarmList</span>
						<a class="iconButton doubleBorder"
						   ng-class="{disabled: !player.hasPlusAccount() || farmListCollection.data.length >= farmListLimit}"
						   tooltip
						   tooltip-show="{{farmListCollection.data.length >= farmListLimit}}"
						   tooltip-translate="FarmList.Tooltip.listLimitReached"
						   clickable="openOverlay('farmListCreation');">
							<i class="symbol_plus_tiny_flat_black"></i>
						</a>
					</div>
				</h6>
				<div class="contentBoxBody" scrollable height-dependency="max">
					<table class="farmListsOverviewTable transparent">
						<tbody ng-repeat="farmlist in farmListCollection.data">
							<tr class="farmListEntry" ng-class="{disabled: !farmlist.data.isDefault && !player.hasPlusAccount()}">
								<td class="selector">
									<input type="checkbox" ng-model="farmlist.checked" ng-change="adjustTroopsInfo();"
										   ng-disabled="farmlist.data.entryIds.length == 0 || (!farmlist.data.isDefault && !player.hasPlusAccount())">
								</td>
								<td clickable="(farmlist.data.isDefault || player.hasPlusAccount()) ? openList({{farmlist.data.listId}},{{$index}}) : null">
									<div class="listName truncated">{{farmlist.data.listName}}</div>
									<div class="villageCounter">
										<i class="village_village_small_flat_black" tooltip tooltip-translate="FarmList.Tooltip.villages"></i>
										<span ng-class="{error: farmlist.data.entryIds.length == 0}">
											{{0 | bidiRatio:farmlist.data.entryIds.length:farmlist.data.maxEntriesCount}}
										</span>
									</div>
									<div class="attackCounter">
										<i class="attack colorIcon" ng-if="!farmlist.data.underAttack" tooltip tooltip-translate="FarmList.NoAttack"></i>
										<i class="reportIcon colorIcon reportIcon115 pending" ng-if="farmlist.data.underAttack && farmlist.data.underAttack < farmlist.data.villageIds.length"
										   tooltip tooltip-translate="FarmList.SomeAttacks"></i>
										<i class="reportIcon colorIcon reportIcon115 pending" ng-if="farmlist.data.underAttack && farmlist.data.underAttack == farmlist.data.villageIds.length"
										   tooltip tooltip-translate="FarmList.AllUnderAttack"></i>
										<span ng-if="farmlist.data.underAttack">{{farmlist.data.underAttack}}</span>
									</div>
									<div class="listInfo">
										<span ng-if="farmlist.data.isDefault || player.hasPlusAccount()">
											<span ng-if="farmlist.data.troopsAmount > 0 && farmlist.data.lastSent">
												<span translate>FarmList.ListOverview.LastStarted</span>
												<span i18ndt="{{farmlist.data.lastSent}}" full="true" format="shortDate"></span> |
												<span i18ndt="{{farmlist.data.lastSent}}" full="true" format="mediumTime"></span>
											</span>
											<span ng-if="farmlist.data.troopsAmount == 0" class="error" translate>FarmList.Error.NoTroopsAssigned</span>
										</span>
										<span ng-if="!farmlist.data.isDefault && !player.hasPlusAccount()">(<span translate>FarmList.Error.PlusAccount</span>)</span>
									</div>
								</td>
								<td>
									<div ng-if="!$first" class="options">
										<div class="optionContainer"
											 clickable="deleteList({{farmlist.data.listId}})"
											 tooltip tooltip-translate="Button.Delete"
											 on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false">
											<i ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"></i>
										</div>
										<div class="optionContainer"
											 clickable="changeListOrder(farmlist.data.listId, {{$index}}+1)"
											 tooltip tooltip-translate="FarmList.MoveDown"
											 ng-class="{disabled: $last}"
											 on-pointer-over="downHover = true" on-pointer-out="downHover = false">
											<i ng-class="{
												symbol_arrowDown_tiny_flat_black: !downHover || $last,
												symbol_arrowDown_tiny_flat_green: downHover && !$last,
												disabled: $last
											}"></i>
										</div>
										<div class="optionContainer"
											 clickable="changeListOrder(farmlist.data.listId, {{$index}}-1)"
											 tooltip tooltip-translate="FarmList.MoveUp"
											 ng-class="{disabled: $index < 2}"
											 on-pointer-over="upHover = true" on-pointer-out="upHover = false">
											<i ng-class="{
												symbol_arrowUp_tiny_flat_black: !upHover || $index < 2,
												symbol_arrowUp_tiny_flat_green: upHover && $index >= 2,
												disabled: $index < 2
											}"></i>
										</div>
									</div>
								</td>
							</tr>
							<tr ng-if="$first">
								<td colspan="3">
									<div class="horizontalLine"></div>
								</td>
							</tr>
							<tr ng-if="$first && $last" class="infoRow" ng-class="{plus: player.hasPlusAccount()}">
								<td colspan="3">
									<span ng-if="player.hasPlusAccount()" translate>FarmList.ListOverview.AddHint</span>
									<span ng-if="!player.hasPlusAccount()" translate>FarmList.ListOverview.PlusHint</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="contentBoxFooter marginToScrollbar">
					<div ng-include="'tpl/building/rallypoint/tabs/partials/FarmListTroopBar.html'"></div>
				</div>
			</div>
		</div>

		<div class="listDetail" ng-if="currentListIndex >= 0">
			<div class="contentBox gradient">
				<h6 class="contentBoxHeader headerTrapezoidal marginToScrollbar">
					<div class="back"
						 clickable="goBackToOverview()"
						 on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
						<i ng-class="{
							symbol_arrowFrom_tiny_flat_black: !fromHover,
							symbol_arrowFrom_tiny_flat_green: fromHover
						}"></i>
						<span translate>Button.Back</span>
					</div>
					<div class="content">
						<div class="nameWrapper">
							<span class="truncated">{{farmListCollection.data[currentListIndex].data.listName}}</span>
							<i class="village_village_small_flat_black" tooltip tooltip-translate="FarmList.Tooltip.villages"></i>
							{{0 | bidiRatio:farmListCollection.data[currentListIndex].data.entryIds.length:farmListCollection.data[currentListIndex].data.maxEntriesCount}}
						</div>
						<i class="headerButton"
						   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
						   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
						   clickable="openOverlay('farmListEdit', {'listId': {{farmListCollection.data[currentListIndex].data.listId}} });"
						   tooltip
						   tooltip-translate="FarmList.Tooltip.editList"></i>
					</div>
					<div class="newFarmList">
						<span translate>FarmList.List.AddVillage</span>
						<a class="iconButton doubleBorder"
						   ng-class="{disabled: farmListCollection.data[currentListIndex].data.entryIds.length >= farmListCollection.data[currentListIndex].data.maxEntriesCount}"
						   clickable="openOverlay('farmListAddVillage', {'listId': {{farmListCollection.data[currentListIndex].data.listId}} });"
						   tooltip tooltip-translate-switch="{
										'FarmList.Tooltip.villageLimitReached': {{farmListCollection.data[currentListIndex].data.entryIds.length >= farmListCollection.data[currentListIndex].data.maxEntriesCount}},
										'FarmList.Tooltip.addVillage': {{farmListCollection.data[currentListIndex].data.entryIds.length < farmListCollection.data[currentListIndex].data.maxEntriesCount}}
								   }">
							<i class="symbol_plus_tiny_flat_black"></i>
						</a>
					</div>
				</h6>
				<div class="contentBoxBody">
					<table class="farmListDetailsTable lined fixedTableHeader" scrollable height-dependency="max">
						<thead>
							<tr ng-class="{reverseSort: reverseSort}" class="marginToScrollbar">
								<th class="selector">
									<input type="checkbox" ng-change="checkAllChange();" ng-model="checkAll.checked"
										   ng-disabled="currentFarmListEntries.data.length == 0"></th>
								<th class="combat" tooltip tooltip-translate="FarmList.Tooltip.CurrentAttacks"
									ng-class="{sort: sort=='underAttack.count'}" clickable="sortBy('underAttack.count')">
									<i class="attack colorIcon"></i>
								</th>
								<th class="name" ng-class="{sort: sort=='villageName'}" clickable="sortBy('villageName')">
									<span translate>FarmList.VillageTitle</span>
								</th>
								<th class="population" tooltip tooltip-translate="Population" ng-class="{sort: sort=='population'}" clickable="sortBy('population')">
									<i class="unit_population_small_flat_black"></i>
								</th>
								<th class="distance" tooltip tooltip-translate="FarmList.Tooltip.distance" ng-class="{sort: sort=='distance'}" clickable="sortBy('distance')">
									<i class="unit_distance_small_flat_black"></i>
								</th>
								<th tooltip tooltip-translate="FarmList.Tooltip.AssignedTroops" ng-class="{sort: sort=='troopsAmount'}" clickable="sortBy('troopsAmount')">
									<i class="generalTroops"></i>
								</th>
								<th tooltip tooltip-translate="FarmList.Tooltip.LastRaidSuccess"
									ng-class="{sort: sort=='lastReport.notificationType'}" clickable="sortBy('lastReport.notificationType')">
									<i class="attack colorIcon"></i>
								</th>
								<th class="carryCol" tooltip tooltip-translate="FarmList.Tooltip.carryStatus"
									ng-class="{sort: sort=='lastReport.raidedResSum'}" clickable="sortBy('lastReport.raidedResSum')">
									<i class="unit_capacity_small_flat_black"></i>
								</th>
								<th class="lastReport" ng-class="{sort: sort=='lastReport.time'}" clickable="sortBy('lastReport.time')">
									<span translate>FarmList.LastSent</span>
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="farm in currentFarmListEntries.data">
								<td class="selector">
									<input type="checkbox" ng-model="farm.checked" ng-change="adjustTroopsInfo()">
								</td>
								<td class="combat">
									<i class="attack colorIcon" ng-if="!farm.data.underAttack" tooltip tooltip-translate="FarmList.NoAttack"></i>
									<i class="reportIcon colorIcon reportIcon3" ng-if="farm.data.underAttack" tooltip tooltip-translate="FarmList.UnderAttack"
									   tooltip-data="count:{{farm.data.underAttack.count}},next:{{farm.data.underAttack.next}}"></i>
								</td>
								<td class="name">
									<div class="villageNameContainer">
										<div ng-if="farm.data.isAlly" class="friendNotice" tooltip tooltip-translate="FarmList.Tooltip.FriendWarning">
											<i class="symbol_warning_tiny_flat_red"></i>
										</div>
										<span village-link villageName="{{farm.data.villageName}}" villageId="{{farm.data.villageId}}"></span>
									</div>
								</td>
								<td class="population">
									<span ng-if="!farm.data.isOasis">{{farm.data.population}}</span>
								</td>
								<td class="distance">
									<span>{{farm.data.distance | number:0}}</span>
								</td>
								<td ng-class="{error: farm.data.troopsAmount == 0}" tooltip tooltip-show="{{farm.data.troopsAmount}}"
									tooltip-url="tpl/building/rallypoint/tabs/partials/AssignedTroopsTooltip.html">
									{{farm.data.troopsAmount || '-'}}
								</td>
								<td>
									<i ng-if="farm.data.lastReport.notificationType" class="reportIcon reportIcon{{farm.data.lastReport.notificationType}} colorIcon"
									   tooltip tooltip-translate="Notification_{{farm.data.lastReport.notificationType}}"></i>
								</td>
								<td class="carryCol">
									<div ng-if="farm.data.lastReport.capacity > 0">
										<i class="carry"
										   tooltip tooltip-translate="Report.CarryCapacityTooltip" tooltip-placement="above"
										   tooltip-data="percent:{{farm.data.lastReport.raidedResSum/farm.data.lastReport.capacity*100|number:0}},used:{{farm.data.lastReport.raidedResSum}},max:{{farm.data.lastReport.capacity}}"
										   ng-class="{
												unit_capacityEmpty_small_flat_black: farm.data.lastReport.raidedResSum == 0,
												unit_capacityHalf_small_flat_black: farm.data.lastReport.raidedResSum > 0 && farm.data.lastReport.raidedResSum < farm.data.lastReport.capacity,
												unit_capacity_small_flat_black: farm.data.lastReport.raidedResSum == farm.data.lastReport.capacity
										   }"></i>
									</div>
								</td>
								<td class="lastReport">
									<a ng-if="farm.data.lastReport.time > 0"
									   clickable="saveRoute('reports');
														  openWindow('reportSingle', {'reportId': '{{farm.data.lastReport.reportId}}', 'collection': 'own', 'highlight': '{{farm.data.villageId}}'}, null, true)">
										<span i18ndt="{{farm.data.lastReport.time}}" format="short"></span>
									</a>
								</td>
								<td>
									<div class="options">
										<div class="optionContainer"
											 clickable="openWindow('farmListAdd', {'targetId': {{farm.data.villageId}}, 'entryId': {{farm.data.entryId}}, 'entryAction': {{FarmListEntry.ACTION.COPY}} })"
											 on-pointer-over="copyHover = true" on-pointer-out="copyHover = false"
											 tooltip tooltip-translate="FarmList.CopyToOtherList">
											<i class="copy"
											   ng-class="{farmlist_copy_small_flat_black: !copyHover, farmlist_copy_small_flat_green: copyHover}"></i>
										</div>
										<div class="optionContainer"
											 clickable="deleteEntry({{farm.data.entryId}})"
											 on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
											 tooltip tooltip-translate="Button.Delete">
											<i ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"></i>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="contentBoxFooter marginToScrollbar">
					<div ng-include="'tpl/building/rallypoint/tabs/partials/FarmListTroopBar.html'"></div>
				</div>
			</div>
		</div>
		<div class="marginToScrollbar">
			<button clickable="openOverlay('farmListEditTroops', {'listId': {{currentListIndex < 0 ? 0 : farmListCollection.data[currentListIndex].data.listId}}, 'entryIds': {{selectedEntries}} });"
					ng-class="{disabled: selectedEntries.length == 0}"
					tooltip tooltip-translate-switch="{
						'FarmList.Tooltip.noListSelected': {{currentListIndex < 0}},
						'FarmList.Tooltip.noVillageSelected': {{currentListIndex >= 0}} }"
					tooltip-show="{{selectedEntries.length == 0}}">
				<span translate>FarmList.Button.editTroops</span>
			</button>
			<button clickable="startRaid()"
					class="startRaid"
					ng-class="{disabled: selectedEntries.length == 0 || troopsAmountNeeded == 0}"
					tooltip
					tooltip-show="{{selectedEntries.length == 0 || !enoughTroops}}"
					tooltip tooltip-translate-switch="{
						'FarmList.Tooltip.noListSelected': {{currentListIndex < 0 && selectedEntries.length == 0}},
						'FarmList.Tooltip.noVillageSelected': {{currentListIndex >= 0 && selectedEntries.length == 0}},
						'FarmList.Notice.notEnoughTroops': {{!enoughTroops}}
					}">
				<span translate>FarmList.Button.startRaid</span>
			</button>
			<i class="troopsWarning symbol_warning_tiny_flat_red" ng-if="troopsAmountNeeded > 0 && !enoughTroops" tooltip tooltip-translate="FarmList.Tooltip.TroopsWarning"></i>
			<span class="error" ng-if="error">{{error}}</span>
		</div>
	</div>
</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/Management.html"><div ng-include src="'tpl/building/partials/buildingInformation.html'"></div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/Overview.html"><div class="buildingRallypointOverview" ng-controller="rallypointOverviewCtrl">
	<div tabulation tab-config-name="rallypointOverviewTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>
	<div class="error">{{overviewError}}</div>
	<button class="sendTroops" clickable="openWindow('sendTroops')">
		<span translate>SendTroops</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/AssignedTroopsTooltip.html"><div class="assignedTroopsTooltip">
	<table class="transparent">
		<tr>
			<td ng-repeat="n in [] | range:1:6" ng-if="n != spyId && farm.data.units[n] > 0">
				<span unit-icon data="n+(player.data.tribeId-1)*10"></span>
				{{farm.data.units[n]}}
			</td>
		</tr>
	</table>
</div>
</script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/Deployed.html"><div class="buildingRallypointOverview troopsTable">
	<h4 ng-if="troopsOverview.troopsCount.Deployed == 0" translate>RallyPoint.Overview.NoTroopsDeployed</h4>
	<h4 ng-if="troopsOverview.troopsCount.Deployed > 0" translate data="count:{{troopsOverview.troopsCount.Deployed}}">RallyPoint.Troops.TitleDeployed</h4>

	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Deployed">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);"></troop-details-rallypoint>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/FarmListAddVillage.html"><div class="farmListAddVillage">
	<search-village check-target-fct="checkTarget" api="villageSearch"></search-village>
</div>
<div class="buttonFooter">
	<div ng-if="error" class="error" translate options="{{error}}">?</div>
	<button clickable="addVillage()" ng-class="{disabled: villageId == 0 || error}">
		<span translate>Button.Add</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Cancel</span>
	</button>
</div>
</script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/FarmListCreation.html"><div class="farmListCreation">
	<label for="farmListCreateInput" translate>FarmList.ListCreation.NewList</label>
	<input id="farmListCreateInput" type="text" maxlength="{{maxLength}}" ng-model="input.listName" placeholder="{{listNamePlaceholder}}">
</div>
<div class="buttonFooter">
	<button clickable="createNewList()" ng-class="{disabled: listName == ''}">
		<span translate>Button.Save</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Cancel</span>
	</button>
</div>
<div ng-if="error" class="error" translate options="{{error}}">?</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/FarmListEdit.html"><div class="farmListEdit">
	<label for="farmListEditInput" translate>FarmList.ListEdit.listName</label>
	<input id="farmListEditInput" type="text" maxlength="{{maxLength}}" ng-model="input.listName" placeholder="{{listNamePlaceholder}}" auto-focus/>
</div>
<div class="buttonFooter">
	<button clickable="editList()" ng-class="{disabled: listName == ''}">
		<span translate>Button.Save</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Cancel</span>
	</button>
</div>
<div class="error">{{editListError}}</div>
</script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/FarmListEditTroops.html"><div class="editUnits">
	<h6 class="headerTrapezoidal">
		<div class="content">
			{{list.data.listName}}
			<i class="village_village_small_flat_black"></i>
			<span ng-if="list">{{0 | bidiRatio:entryIds.length:list.data.maxEntriesCount}}</span>
			<span ng-if="!list">{{entryIds.length}}</span>
		</div>
	</h6>
	<span translate>FarmList.EditTroops.description</span>
	<div troops-details troop-data="troopDetails" unit-input-callback="checkInput"></div>
	<div class="error" ng-if="editTroopsError"><i class="symbol_warning_tiny_flat_red"></i><span translate options="{{editTroopsError}}">?</span></div>
	<div class="buttonFooter">
		<button ng-class="{disabled: noUnitSelected || !unitInputChanged}"
				clickable="saveTroops()">
			<span translate>Button.Save</span>
		</button>
		<button clickable="closeOverlay();" class="cancel">
			<span translate>Button.Cancel</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/FarmListTroopBar.html"><div class="troopBar">
    <div class="troops">
		<div class="troopInfo" ng-repeat="info in troopInfo">
			<span unit-icon data="tribeId,info.id"
				       tooltip
					   tooltip-translate="Troop_{{((tribeId - 1) * 10) + info.id}}"
				       ng-class="{notUsed: info.needed == 0}">
			</span>
			<div class="troop enoughTroops" ng-if="info.needed == 0">
				-
			</div>
			<div class="troop" ng-if="info.needed > 0" ng-class="{enoughTroops: info.enoughTroops}">
				{{info.needed}}
			</div>
		</div>
		<span class="description" translate>FarmList.TroopBar.TotalUnits</span>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/Incoming.html">
<div class="buildingRallypointOverview troopsTable">
	<div class="filterBar">
		<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.attack == 1}" tooltip tooltip-translate="RallyPoint.Overview.Attack" clickable="filterTroops('attack', 'Incoming')">
			<i class="movement_attack_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.support == 1}" tooltip tooltip-translate="RallyPoint.Overview.Support" clickable="filterTroops('support', 'Incoming')">
			<i class="movement_support_small_flat_black"></i>
		</a>
		<!--<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.attackOasis == 1}" tooltip tooltip-translate="RallyPoint.Overview.AttackOasis" clickable="filterTroops('attackOasis', 'Incoming')">-->
			<!--<i class="movement_attackOasis_small_flat_black"></i>-->
		<!--</a>-->
		<!--<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.supportOasis == 1}" tooltip tooltip-translate="RallyPoint.Overview.SupportOasis" clickable="filterTroops('supportOasis', 'Incoming')">-->
			<!--<i class="movement_supportOasis_small_flat_black"></i>-->
		<!--</a>-->
		<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.trade == 1}" tooltip tooltip-translate="RallyPoint.Overview.Trade" clickable="filterTroops('trade', 'Incoming')">
			<i class="movement_trade_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.tribute == 1}" tooltip tooltip-translate="RallyPoint.Overview.Tribute" clickable="filterTroops('tribute', 'Incoming')"
			ng-if="player.data.isKing">
			<i class="movement_tribute_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Incoming.healing == 1}" tooltip tooltip-translate="RallyPoint.Overview.Healing" clickable="filterTroops('healing', 'Incoming')">
			<i class="movement_heal_small_flat_black"></i>
		</a>
	</div>
	<!-- Incoming troops -->
	<h4 ng-if="troopsOverview.troopsCount.Incoming == 0" translate>RallyPoint.Overview.NoTroopsIncoming</h4>
	<h4 ng-if="troopsOverview.troopsCount.Incoming > 0" translate data="count:{{troopsOverview.troopsCount.Incoming}}">RallyPoint.Troops.TitleIncoming</h4>

	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Incoming">
		<troop-details-rallypoint troop-details="troopDetails" class="movingTroops"></troop-details-rallypoint>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/Local.html"><div class="buildingRallypointOverview troopsTable">
	<!-- homeTroops this will always be shown -->
	<h4 translate data="count:{{troopsOverview.troopsCount.Local}}">
		RallyPoint.Troops.TitleHome</h4>

	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Local.home">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);"></troop-details-rallypoint>
	</div>
	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Local.support">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);" callback="expandGroup(type, tribe)"></troop-details-rallypoint>
	</div>
	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Local.trap">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);" callback="expandGroup(type, tribe)"></troop-details-rallypoint>
	</div>
	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Local.nature">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);"></troop-details-rallypoint>
	</div>
	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Local.regenerating">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);"></troop-details-rallypoint>
	</div>

</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/Oases.html"><div class="buildingRallypointOverview troopsTable">
	<h4 ng-if="troopsOverview.troopsCount.Oases == 0" translate>RallyPoint.Overview.NoTroopsOases</h4>
	<h4 ng-if="troopsOverview.troopsCount.Oases > 0" translate data="count:{{troopsOverview.troopsCount.Oases}}">RallyPoint.Troops.TitleOases</h4>
	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Oases">
		<troop-details-rallypoint troop-details="troopDetails" send-troops="sendTroops(troops, type);" view="oasis"></troop-details-rallypoint>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/Outgoing.html"><div class="buildingRallypointOverview troopsTable">
	<div class="filterBar">
		<a class="filter iconButton" ng-class="{active: troopsFilter.Outgoing.attack == 1}" tooltip tooltip-translate="RallyPoint.Overview.Attack" clickable="filterTroops('attack', 'Outgoing')">
			<i class="movement_attack_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Outgoing.spy == 1}" tooltip tooltip-translate="RallyPoint.Overview.Spy" clickable="filterTroops('spy', 'Outgoing')">
			<i class="movement_spy_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Outgoing.support == 1}" tooltip tooltip-translate="RallyPoint.Overview.Support" clickable="filterTroops('support', 'Outgoing')">
			<i class="movement_support_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Outgoing.adventure == 1}" tooltip tooltip-translate="RallyPoint.Overview.Adventure" clickable="filterTroops('adventure', 'Outgoing')">
			<i class="movement_adventure_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Outgoing.settle == 1}" tooltip tooltip-translate="RallyPoint.Overview.Settle" clickable="filterTroops('settle', 'Outgoing')">
			<i class="movement_settle_small_flat_black"></i>
		</a>
		<a class="filter iconButton" ng-class="{active: troopsFilter.Outgoing.trade == 1}" tooltip tooltip-translate="RallyPoint.Overview.Trade" clickable="filterTroops('trade', 'Outgoing')">
			<i class="movement_trade_small_flat_black"></i>
		</a>
	</div>
	<!-- Outgoing troops -->
	<h4 ng-if="troopsOverview.troopsCount.Outgoing == 0" translate>RallyPoint.Overview.NoTroopsOutgoing</h4>
	<h4 ng-if="troopsOverview.troopsCount.Outgoing > 0" translate data="count:{{troopsOverview.troopsCount.Outgoing}}">RallyPoint.Troops.TitleOutgoing</h4>

	<div ng-repeat="troopDetails in troopsOverview.displayTroops.Outgoing">
		<troop-details-rallypoint troop-details="troopDetails" abort="abortTroopMovement(troopId);" class="movingTroops"></troop-details-rallypoint>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/rallypoint/tabs/partials/startRaidTooltip.html"><div class="startRaidTooltip">
    <div ng-if="currentListIndex < 0">
        <div ng-if="nothingSelected" translate>FarmList.Tooltip.noListSelected</div>
        <div ng-if="notSendable" translate>FarmList.Tooltip.notSendable</div>
    </div>
    <div ng-if="currentListIndex >= 0">
        <div ng-if="nothingSelected" translate>FarmList.Tooltip.noVillageSelected</div>
        <div ng-if="notSendable" translate>FarmList.Tooltip.notSendable</div>
    </div>
	<div ng-if="!enoughTroops" translate data="amountVillages:{{amountAttackableVillages}}">
		FarmList.Notice.notEnoughTroops
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/resources/resources_main.html"><div class="buildingDetails" ng-controller="resourceBuildingCtrl">
	<div ng-include src="'tpl/building/partials/buildingInformation.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/building/rubble/rubble_main.html"><div class="buildingDetails rubbleDetails">
	<div class="contentBox gradient buildingEffect">
		<h6 class="contentBoxHeader headerColored">
			<span translate>Building_Rubble.Pile</span>
		</h6>
		<div class="contentBoxBody">
			<div class="current">
				<h6 class="headerTrapezoidal">
					<div class="content" translate>Duration</div>
				</h6>
				<div class="timeValue">
					<i class="symbol_clock_small_flat_black duration"></i>{{building.data.rubbleDismantleTime|HHMMSS}}
				</div>
			</div>
			<div class="nextLvl">
				<h6 class="headerTrapezoidal">
					<div class="content" translate>Resources</div>
					<div class="maxLvl">
						<display-resources resources="building.data.rubble"
										   color-positive="true"
										   signed="true"
										   check-storage="true"></display-resources>
					</div>
				</h6>
			</div>
		</div>
	</div>
	<button clickable="collectRubble()" ng-disabled="!canCollectRubble()" ng-class="{disabled: !canCollectRubble()}">
		<span translate>ContextMenu.button.fetchResources</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/building/smithy/smithy_main.html"><div class="buildingDetails blacksmith" ng-controller="blacksmithCtrl">
	<div ng-show="isBuildingBuild()">
		<div ng-controller="unitsResearchCtrl">
			<div ng-include src="'tpl/building/partials/lists/units.html'"></div>

			<!-- queue full -->
			<button ng-class="{disabled: unitsResearch.data.upgradeQueueFull || !activeItem || !activeItem.canUpgrade || !enoughResources(activeItem)}"
					class="footerButton"
					clickable="research(activeItem)"
					tooltip
					tooltip-translate-switch="{
						'Blacksmith.NoAdditionalUpgrade': {{unitsResearch.data.upgradeQueueFull}},
						'Blacksmith.NothingSelected': {{!activeItem}},
						'Blacksmith.RequirementsNotFullfilled': {{!activeItem.canUpgrade}},
						'Error.NotEnoughRes': {{!enoughResources(activeItem)}}
						}">
				<span translate>Blacksmith.Upgrade</span>
			</button>

			<npc-trader-button class="footerButton" type="unitUpgrade" costs="{{activeItem.costs}}"></npc-trader-button>
			<div class="iconButton premium finishNow"
				 premium-feature="{{::FinishNowFeatureName}}"
				 premium-callback-param="finishNowBuildingType:{{building.data.buildingType}}"
				 confirm-gold-usage="true"
				 tooltip tooltip-url="tpl/npcTrader/finishNowTooltip.html">
				<i class="feature_instantCompletion_small_flat_black"></i>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/townHall/townHall_main.html"><div class="buildingDetails townHall" ng-controller="celebrationsStartCtrl">
	<div ng-show="isBuildingBuild()">
		<div ng-include src="'tpl/building/partials/lists/celebrations.html'"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/trainTroops/trainTroops_main.html"><div class="buildingDetails trainTroops" ng-controller="trainTroopsCtrl">
	<div ng-show="isBuildingBuild()">
		<div ng-controller="unitsTrainCtrl">
			<div ng-include src="'tpl/building/partials/lists/units.html'"></div>

			<!-- unit not researched -->
			<button ng-class="{disabled: activeItem.disabled || allValue <= 0 || activeItem.maxAvailable == 0}"
					class="footerButton"
					clickable="startTraining(activeItem)"
					tooltip
					tooltip-translate-switch="{
						'TrainTroops.NotResearched': {{activeItem.disabled == true}},
						'TrainTroops.SetAmount': {{allValue <= 0}},
						'Error.NotEnoughRes': {{activeItem.maxAvailable == 0}}
						}"
					play-on-click="{{UISound.BUTTON_TRAIN_TROOPS}}">
				<span translate>Button.Train</span>
			</button>

		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/trapper/trapper_main.html"><div class="buildingDetails trapper" ng-controller="trapperCtrl">
	<div ng-show="isBuildingBuild()">
		<div ng-include src="'tpl/building/partials/lists/traps.html'"></div>
	</div>
</div>

</script>
<script type="text/ng-template" id="tpl/building/treasury/territoryTooltip.html"><div class="territoryTooltip" ng-controller="futureTerritoryBonusCtrl">
	<h3 translate>
		Treasury.TerritoryBonus
	</h3>
	<div class="horizontalLine"></div>
	<table class="transparent">
		<tbody>
			<tr ng-repeat="n in [] | range:0:3">
				<td ng-if="nextBoundaries[n]" data="value:{{nextBoundaries[n]}}" translate>Treasury.Treasures</td>
				<td ng-if="nextBoundaries[n]">{{nextBonuses[n] | bidiNumber:'percent':false:false}}</td>
			</tr>
		</tbody>
	</table>
</div>

</script>
<script type="text/ng-template" id="tpl/building/treasury/treasury_main.html"><div class="buildingDetails treasury" ng-controller="treasuryCtrl">
	<div ng-show="isBuildingBuild()">
        <div ng-include="tabBody"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/treasury/overlay/deactivateTreasury.html"><span translate>Treasury.DeactivateTreasury.Text</span>
<span ng-if="isKing" translate>Treasury.DeactivateTreasury.Text.King</span>
<span ng-if="isDuke" translate>Treasury.DeactivateTreasury.Text.Duke</span>
<div class="buttonFooter">
	<button clickable="confirmDeactivation(); closeOverlay();">
		<span translate>Treasury.TransformButton.Deactivate</span>
	</button>
	<button clickable="closeOverlay();" ng-class="{disabled: currentPlayer.data.hasNoobProtection}" class="cancel">
		<span translate>Button.Cancel</span>
	</button>
</div>
</script>
<script type="text/ng-template" id="tpl/building/treasury/tabs/Artifacts.html"></script>
<script type="text/ng-template" id="tpl/building/treasury/tabs/Overview.html"></script>
<script type="text/ng-template" id="tpl/building/treasury/tabs/Treasures.html"><div class="contentBox">
	<h6 class="contentBoxHeader headerWithArrowEndings glorious">
		<div class="content" translate>
			Treasury.TreasuresAndBonuses
		</div>
	</h6>
	<div class="contentBoxBody">
		<span translate>Treasury.TreasureDescription</span>
		<div progressbar type="{{(treasures > treasuresUsable) ? 'negative' : 'positive'}}" class="treasureBar" perc="{{treasuryFilledPerc}}"></div>
		<div class="treasureCount" ng-class="{full: treasures > treasuresUsable}">
			<span translate>Treasury.Capacity</span>
			: <i class="unit_treasure_small_illu" tooltip tooltip-translate="Resource.Treasures"></i>
			<span ng-bind-html="treasures | bidiRatio:treasures:treasuresUsable"></span>
		</div>
		<div class="floatWrapper">
			<div class="contentBox resources">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content" translate>Treasury.ResourceBonus</div>
				</h6>
				<div class="contentBoxBody">
					<display-resources resources="treasureResourceBonus" production="true"></display-resources>
				</div>
			</div>
			<div class="contentBox victoryPoints">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content" translate>Treasury.Victorypoints</div>
				</h6>
				<div class="contentBoxBody">
					<div ng-if="!alliance" class="noAlliance productionPerDay" translate>Treasury.AllianceNeeded</div>
					<div ng-if="alliance" class="productionPerDay" data="production: {{homeProductionPerDay}}" translate>Treasury.VictoryPointsPerHour</div>
				</div>
			</div>
		</div>
		<div class="contentBox gradient territoryContainer">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content">
					<span translate>Treasury.TerritoryInfluenceAndBonuses</span>
				</div>
			</h6>
			<div class="contentBoxBody">
				<span translate>Treasury.TerritoryDescription</span>
				<div class="influenceProgress">
					<div class="territoryBonusLevel">
						<span translate>level</span>
						<span ng-bind-html="territoryBonusLevel | bidiRatio:territoryBonusLevel:building.data.lvl"></span>
					</div>
					<div class="currentBonus">
						<span translate>Treasury.TerritoryBonus</span>
						: {{currentTerritoryBonus | bidiNumber:"percent"}}
					</div>
					<table class="transparent">
						<tbody>
							<tr>
								<td ng-repeat="n in [] | range:1:20" ng-class="{disabled: building.data.lvl < n}"
									tooltip tooltip-translate="Treasury.TerritoryLevel{{n > building.data.lvl ? '.Locked' : ''}}.ToolTip" tooltip-placement="above"
									tooltip-data="value:{{influenceLevels[n-1]['treasures']}},bonus:{{influenceLevels[n-1]['factor']}},required:{{n}}">
									<div progressbar perc="{{n <= territoryBonusLevel ? 100 :
														 n == territoryBonusLevel+1 && n <= building.data.lvl ? currentLevelPercent : 0}}"></div>
								</td>
							</tr>
						</tbody>
					</table>
					<span translate class="error" ng-if="territoryBonusLevel == building.data.lvl && building.data.lvl < 20">Treasury.MaximumBonusReached</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="transform contentBox gradient">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content">
			<span translate>Treasury.Transform</span>
		</div>
	</div>
	<div class="contentBoxBody">
		<div class="floatWrapper">
			<div ng-show="!transformationFinished" class="activateInfo">
				<span translate>Treasury.TransformText</span>
			</div>
			<div ng-show="transformationFinished"class="activateInfo">
				<span translate data="duration:{{transformationFinished}}">Treasury.TransformationFinishedIn</span>
			</div>
			<div class="activateControl">
				<button clickable="transformToHiddenTreasury()" ng-show="!transformationFinished" ng-class="{disabled: lastActiveTreasury}"
						tooltip tooltip-translate="Treasury.TransformButton.Last.Tooltip" tooltip-show="{{lastActiveTreasury}}">
					<span translate>Treasury.TransformButton.Deactivate</span>
				</button>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/building/worldWonder/resourceListTooltip.html"><div class="resourceListTooltip">
	<h3 translate>Resources</h3>
	<div class="horizontalLine"></div>
	<display-resources ng-show="type == 'total'" resources="contributor.data.resources"></display-resources>
	<display-resources ng-show="type == 'today'" resources="contributor.data.resourcesToday"></display-resources>
</div></script>
<script type="text/ng-template" id="tpl/building/worldWonder/worldWonder_main.html"><div class="buildingDetails worldWonder" ng-controller="worldWonderCtrl">
	<div class="contentBox">
		<div class="contentBoxBody">
			<div class="contentBox gradient level">
				<div class="contentBoxHeader headerTrapezoidal">
					<div class="content">
						<span ng-bind-html="worldWonder.currentLevel | bidiRatio : worldWonder.currentLevel : worldWonder.maxLevel"></span>
						<span translate>level</span>
					</div>
				</div>
				<div class="contentBoxBody">
					<div progressbar perc="{{worldWonder.currentLevel / (worldWonder.maxLevel / 100)}}"></div>
				</div>
			</div>
			<div class="contentBox gradient rank bonus">
				<div class="contentBoxBody">
					<span>
						<span translate>Rank</span>
						<span tooltip tooltip-translate="WorldWonder.RankingTooltip"><i class="chaplet" ng-class="{gold: worldWonder.rank == 1,silver: worldWonder.rank == 2,bronze: worldWonder.rank == 3,green: worldWonder.rank > 3}"></i>{{worldWonder.rank}}</span>
					</span>
					<span>
						<span translate>WorldWonder.Bonus</span>
						<span class="bonusValue" tooltip tooltip-translate="WorldWonder.VictoryPointsBonusTooltip">{{worldWonder.bonus | bidiNumber:'percent':true:false}}</span>
					</span>
				</div>
			</div>

			<div class="contentBox gradient topContributors">
				<div class="contentBoxHeader headerTrapezoidal">
					<div class="content" translate>
						WorldWonder.TopContributorsResources
					</div>
				</div>
				<div class="contentBoxBody">
					<div ng-repeat="contributor in contributors.resources" class="topResourcesRow">
						<span class="playerName">{{$index|rank}}. <span player-link playerId="{{contributor.data.playerId}}" playerName="{{contributor.data.playerName}}"></span></span>
						<span class="playersResources">
							<span class="allResources" tooltip tooltip-data="type:total" tooltip-url="tpl/building/worldWonder/resourceListTooltip.html">
								<i class="unit_resourcesAndCrop_small_illu"></i><span translate>Total</span>: <span class="value">{{contributor.data.resources.sum}}</span>
							</span>
							<span class="resourcesToday" tooltip tooltip-data="type:today" tooltip-url="tpl/building/worldWonder/resourceListTooltip.html">
								<span translate>Chat.Time_Today</span>: <span class="value">{{contributor.data.resourcesToday.sum}}</span>
							</span>
						</span>
					</div>
				</div>
			</div>

			<div class="contentBox topContributors">
				<div class="contentBoxHeader headerTrapezoidal">
					<div class="content" translate>
						WorldWonder.TopContributorsTroops
					</div>
				</div>
				<div class="contentBoxBody">
					<div ng-repeat="contributor in contributors.troops" class="troopsDetailContainer">
						<div class="troopsDetailHeader">
							{{$index|rank}}. <span player-link playerId="{{contributor.playerId}}" playerName="{{contributor.playerName}}"></span>
						</div>
						<div troops-details troop-data="contributor"></div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/chat/chat.html"><div class="chatWindow" ng-controller="privateChatWindowCtrl">
	<div class="chatControls">
		<div ng-include src="'tpl/chat/partials/chatRoomHeader.html'"></div>
	</div>
	<div class="unDockedChatBody">
		<chat-window-body room="room"></chat-window-body>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/chat/chatFooterBar.html"><div id="chatFooterBar" ng-controller="chatBarCtrl">
	<div ng-include src="'tpl/chat/chatMenu.html'" ng-if="chatInit" ng-show="chatMenuOpen"></div>

	<a class="mainLayoutMenuButton directionDown toggleChatMenu"
	   clickable="toggleMenu()"
	   ng-class="{active: chatMenuOpen}"
	   tooltip
	   tooltip-translate="Chat.chat"
	   tooltip-placement="top">
		<i class="chat_menu_medium_flat_black"></i>
		<div class="unreadNotification" ng-hide="chatMenuOpen || chat.unreadMessages === 0">
			<span>{{chat.unreadMessages}}</span>
		</div>
	</a>
	<div class="disconnectIndicator" tooltip tooltip-url="tpl/chat/partials/disconnectedTooltip.html" tooltip-class="warning" ng-if="!chat.connected">
		<i class="chat_disconnected_small_illu"></i>
	</div>

	<dynamic-tabulation watch-var="chat.openChatWindows" collection-key="data.roomId" active-tab="{{activeTab}}"
		class="dynamicTabulation tabWrapper" ng-class="{disconnected: !chat.connected}">
		<div class="tabWrapper" ng-class="{chatMenuOpened: chatMenuOpen}">
			<div ng-repeat="chatInfo in tabs"
				 class="footerButton chatButton room chatInbox" ng-class="{open: chatInfo.data.isDocked, selected: chatInfo.data.roomId == activeTab}">
				<div class="chatNameContainer" clickable="openChat(chatInfo.data.roomId)">
					<div class="chatName">
						<chat-room-name room-name="chatInfo.data.chatUser.data.name"
										alliance-rights="chatInfo.data.chatUser.data.allianceRights"
										last-click="chatInfo.data.chatUser.data.lastClick"
										online="chatInfo.data.chatUser.data.online"></chat-room-name>
						<span ng-repeat="(playerId, status) in chat.typingStatus[chatInfo.data.roomId]">
							<span ng-if="status > currentServerTime-20">
								<i class="action_edit_small_flat_black"
								   tooltip tooltip-url="tpl/chat/partials/typingNotificationTooltip.html" tooltip-data="playerId:{{playerId}},playerName:"></i>
							</span>
						</span>
						<div class="unreadNotification" ng-if="chatInfo.data.chatInbox.data.unread > 0">
							<span>{{chatInfo.data.chatInbox.data.unread}}</span>
						</div>
						<div class="newChatWrapper" ng-if="chatInfo.data.isNew">
							<div class="newChat">
								<span translate>Chat.New</span>
							</div>
						</div>
					</div>
				</div>
				<div ng-include src="'tpl/chat/dockedChat.html'" ng-if="chatInfo.data.isDocked" class="dockedChatWindow"></div>
			</div>
		</div>
		<div class="footerButton chatButton showHidden room" clickable="toggleDropdown()" ng-show="tabsMore.length > 0">
			<span class="moreTabsAmount">{{tabsMore.length}}</span>
			<i class="symbol_arrowUp_tiny_illu"></i>
			<div class="unreadNotification" ng-if="tabsMore.length > 0 && isUnreadMessagesHidden(tabsMore)">
				<span>{{moreDropdownUnread}}</span>
			</div>
			<div class="dropdownBody dynamicTabulationDropdown" ng-show="showHiddenTabsDropdown">
				<ul>
					<li ng-repeat="chatInfo in tabsMore">
						<div class="chatNameContainer">
							<div class="chatName roomType" clickable="openChat(chatInfo.data.roomId); toggleDropdown();">
								<chat-room-name room-name="chatInfo.data.chatUser.data.name"
												alliance-rights="chatInfo.data.chatUser.data.allianceRights"
												last-click="chatInfo.data.chatUser.data.lastClick"
												online="chatInfo.data.chatUser.data.online"></chat-room-name>
								<span ng-if="chatInfo.data.chatInbox.data.unread"> ({{chatInfo.data.chatInbox.data.unread}})</span>
								<div class="newChatWrapper" ng-if="chatInfo.data.isNew">
									<div class="newChat">
										<span translate>Chat.New</span>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</dynamic-tabulation>
</div></script>
<script type="text/ng-template" id="tpl/chat/chatMenu.html"><div class="chatMenu" ng-controller="chatMenuCtrl">
	<div class="menuItems">
		<div class="menuItem" ng-repeat="(key, item) in menuItems" ng-if="item.visible"
			 ng-class="{
			 	selected: room.roomId == item.roomId,
			 	unread: item.unreadLines > 0
			 }"
			 tooltip tooltip-translate="Chat.Tooltip.{{::item.chatRoom.getTypeString()}}" tooltip-data="name:{{::item.model.data.name}}"
			 clickable="::selectMenuTab({{key}})">
			<i ng-if="item.chatRoom.data.joined" class="{{::item.icon}}"></i>
			<i ng-if="!item.chatRoom.data.joined" class="{{::item.iconDisabled}}"></i>
		</div>
		<div class="moreSecretSociety menuItem" ng-if="secretSocietyCount > 2" ng-class="{unread: secretSocietyDropdownUnread > 0}">
			<div class="options" more-dropdown more-dropdown-options="getSecretSocietyOptions()" more-dropdown-count="{{secretSocietyCount-1}}"></div>
		</div>
	</div>
	<div class="chatRoomHeader">
		<span translate ng-if="room.chatRoom.data.roomId === ChatRoom.GLOBAL">Chat.Global</span>
		<span translate ng-if="room.chatRoom.data.roomId === ChatRoom.BEGINNER">Chat.Beginner</span>
		<div ng-if="room.chatRoom.getRoomType() === ChatRoom.TYPE_ALLIANCE">
			<span ng-if="room.chatRoom.getRoomName() !== 0"><alliance-link allianceId="{{room.chatRoom.getRoomName()}}" allianceName=""></alliance-link> |</span> <span class="text" translate >Alliance</span>
		</div>
		<div ng-if="room.chatRoom.getRoomType() === ChatRoom.TYPE_KINGDOM">
			<span ng-if="room.chatRoom.getRoomName() !== 0"><span player-link playerId="{{room.chatRoom.getRoomName()}}"></span> |</span> <span class="text" translate >Kingdom</span>
		</div>
		<div ng-if="room.chatRoom.getRoomType() === ChatRoom.TYPE_SECRET_SOCIETY">
			<span ng-if="room.chatRoom.getRoomName() !== 0"><secret-society-link societyId="{{room.model.data.groupId}}" societyName="{{room.model.data.name}}"></secret-society-link> |</span> <span class="text" translate >SecretSociety</span>
		</div>
		<div class="options" ng-if="room.chatRoom.data.joined !== 0" more-dropdown more-dropdown-options="getRoomOptions()"></div>
	</div>
	<div class="chatWindow">
		<div class="notJoined" ng-if="room.chatRoom.getRoomName() === 0">
			<i class="no_chat_member_medium_flat_black"></i>
			<span class="text" translate ng-if="room.chatRoom.getRoomType() === ChatRoom.TYPE_ALLIANCE">Chat.NoAlliance</span>
			<span class="text" translate ng-if="room.chatRoom.getRoomType() === ChatRoom.TYPE_KINGDOM">Chat.NoKingdom</span>
		</div>
		<div class="notJoined" ng-if="room.chatRoom.data.joined === 0 && room.chatRoom.getRoomName() !== 0">
			<i class="no_chat_member_medium_flat_black"></i>
			<span class="text" translate>Chat.NeedToJoinChatRoom</span>
			<span class="textOnline" translate data="count: {{room.chatRoom.data.members}}">Chat.CurrentlyOnline</span>
			<button clickable="joinChat()" tooltip tooltip-translate="Chat.JoinButtonTooltip" ng-class="{disabled: isBannedFromMessaging}">
				<span translate>Chat.JoinButton</span>
			</button>
		</div>
		<chat-room-notifications room-id="{{room.roomId}}"></chat-room-notifications>
		<chat-window-body room="room" ng-if="$parent.chatMenuOpen"></chat-window-body>
	</div>
	<chat-room-members room="room.chatRoom"></chat-room-members>
</div></script>
<script type="text/ng-template" id="tpl/chat/chatRoomBody.html"><div class="chatBody" scrollable scroll-down dropable="checkDrop(object)" ng-click="setChatInputState(0)">

	<ul>
		<li class="divider loadOlder" ng-if="chatLines.length> 0 && !haveFirst">
			<span><a translate clickable="loadOlder()">Chat.LoadOlderMessages</a></span>
		</li>

		<li ng-repeat-start="inboxLine in (orderedData = (chatLines | orderBy:'data.timestamp')) as repeatList">
			<chat-time-divider last="{{::orderedData[$index-1].data.timestamp}}" current="{{::inboxLine.data.timestamp}}" reverse="true"></chat-time-divider>
		</li>
		<li class="line"
			ng-class="{
				currentPlayer: player.data.playerId == inboxLine.data.playerId && !isMonologue,
				otherPlayer: player.data.playerId != inboxLine.data.playerId || isMonologue,
				samePlayerAndTime : orderedData[$index-1].data.timestamp > inboxLine.data.timestamp-60000 && orderedData[$index-1].data.playerId == inboxLine.data.playerId && (!repeatList[$index-1].data.isFirst || selectedConversation.data.isPrivateChat),
				new: inboxLine.data.newLine == 1,
				fade: inboxLine.data.newLine == 2,
				firstMassMail: inboxLine.data.isFirst && selectedConversation.data.isMassMail
				}">
			<div class="lineHead">
				<span class="name truncated">{{::inboxLine.data.playerName }}</span>
				<div class="options" ng-if="::inboxLine.data.playerId != player.data.playerId"
					 more-dropdown more-dropdown-options="getPlayerOptions({{::inboxLine.data.playerId}})"></div>
				<span class="date" i18ndt="{{::inboxLine.data.timestamp / 1000 }}" format="veryShort"></span>
			</div>
			<div class="lineBody" user-text-parse="inboxLine.data.text" parse="decorations;linkings;reports;coordinates" room-id="{{::roomId}}"></div>
			<div class="readNotification" ng-if="!isMonologue">
				<i class="action_check_tiny_flat_green" ng-if="selectedConversation.data.isPrivateChat && player.data.playerId == inboxLine.data.playerId && selectedConversation.data.lastOtherRead >= inboxLine.data.timestamp" tooltip tooltip-translate="Chat.HasReadMessage"></i>
				<i class="action_check_tiny_flat_black gray" ng-if="selectedConversation.data.isPrivateChat && player.data.playerId == inboxLine.data.playerId && selectedConversation.data.lastOtherRead < inboxLine.data.timestamp" tooltip tooltip-translate="Chat.HasNotReadMessage"></i>
			</div>
			<div class="conversationSummary" ng-if="::inboxLine.data.isFirst && selectedConversation.data.isMassMail && selectedConversation.data.totalParticipents > 0 && inboxLine.data.playerId == player.data.playerId">
				<div class="horizontalLine"></div>
				{{0 | bidiRatio:selectedConversation.data.otherRead:selectedConversation.data.totalParticipents}}
				<i class="action_check_tiny_flat_green" ng-if="selectedConversation.data.otherRead >= selectedConversation.data.totalParticipents" tooltip tooltip-translate="Chat.HasReadMessage"></i>
				<i class="action_check_tiny_flat_black gray" ng-if="selectedConversation.data.otherRead < selectedConversation.data.totalParticipents && selectedConversation.data.otherRead > 0" tooltip tooltip-url="tpl/igm/readStatistic.html"></i>
			</div>
		</li>

		<li ng-repeat-end>
			<div class="divider" ng-if="::inboxLine.data.isFirst && selectedConversation.data.isMassMail">&nbsp;</div>
		</li>


		<li ng-repeat="line in unsentLines">
			<div class="line unsentLine currentPlayer">
				{{ line.data.playerName }} <span i18ndt="{{line.data.timestamp / 1000 }}" format="short"></span>
				{{ line.data.text }}
			</div>
		</li>
	</ul>

</div>
<textarea ng-disabled="isBannedFromMessaging" ng-if="isBannedFromMessaging" placeholder="{{answerPlaceholder}}"  row="2" class="chatInput"></textarea>
<textarea ng-disabled="!isActivated" ng-if="!isActivated && !isBannedFromMessaging" placeholder="{{isActivatedAnswerPlaceholder}}"  row="2" class="chatInput"></textarea>
<textarea ng-if="!isBannedFromMessaging && isActivated" row="2" class="chatInput" chat-input send-function="send" room-id="{{roomId}}" dropable="checkDrop(object)"></textarea>
</script>
<script type="text/ng-template" id="tpl/chat/chatRoomMembers.html"><div class="chatMembers">
	<div class="prev" ng-click="prev()" ng-class="{disabled: startIndex === 0}" ng-if="chatMembers.length > 0"></div>
	<div class="members">
		<div on-pointer-over="showTooltip = true" on-pointer-out="showTooltip = false">
			<div ng-repeat="member in chatMembers" on-pointer-over="highlightMember($index)">
				<chat-room-member ng-if="member.data.status !== ChatUser.STATUS_OFFLINE" show-prestige="true" show-tooltip="false"></chat-room-member>
			</div>
		</div>
	</div>
	<div class="names" ng-class="{slideOut: showTooltip || nameHover}" on-pointer-over="nameHover = true" on-pointer-out="nameHover = false">
		<div class="container" on-pointer-over="showTooltip = true" on-pointer-out="showTooltip = false">
			<div ng-repeat="member in chatMembers" ng-if="member.data.status !== ChatUser.STATUS_OFFLINE" ng-class="{highlight: $index === tooltipIndex}" on-pointer-over="highlightMember($index)" clickable="clickPlayerAvatar({{member.data.playerId}})">
				<div class="name">{{member.data.name}}</div>
				<div class="prestigeDecor"></div>
			</div>
		</div>
	</div>
	<div class="next" ng-click="next()" ng-class="{disabled: startIndex + maxAmount >= allMembers.length}" ng-if="chatMembers.length > 0"></div>
</div></script>
<script type="text/ng-template" id="tpl/chat/dockedChat.html"><div class="chatWindow">
	<div chat ng-controller="privateChatWindowCtrl">
		<div class="chatControls">
			<div ng-include src="'tpl/chat/partials/chatRoomHeader.html'"></div>
		</div>
		<div class="dockedChatBody">
			<chat-window-body room="room"></chat-window-body>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/chat/partials/chatRoomHeader.html"><div class="chatHeader" ng-controller="chatRoomHeaderCtrl" ng-class="{draggableHeader: !chatInfo.data.isDocked}">
	<chat-room-member player-id="{{chatInfo.data.chatUser.data.playerId}}" show-prestige="true" private-chat-mode="{{isPrivateChat}}"></chat-room-member>
	<span player-link class="playerName" playerId="{{chatInfo.data.chatUser.data.playerId}}"></span>
	<div class="membership">
		<span ng-if="chatInfo.data.chatUser.data.allianceId > 0"><alliance-link allianceId="{{chatInfo.data.chatUser.data.allianceId}}" allianceName="" nolink="true"></alliance-link> | </span>
		<span player-link ng-if="chatInfo.data.chatUser.data.kingdomId !== 0" nolink="true" playerId="{{chatInfo.data.chatUser.data.kingdomId}}"></span>
	</div>
	<div class="flagHanger" ng-class="{king: otherPlayerRole == Player.KINGDOM_ROLE_KING, duke: otherPlayerRole == Player.KINGDOM_ROLE_DUKE}">
		<div class="flag"></div>
		<i class="community_governor_small_flat_black" ng-if="otherPlayerRole == Player.KINGDOM_ROLE_GOVERNOR"></i>
		<i class="community_king_small_flat_black" ng-if="otherPlayerRole == Player.KINGDOM_ROLE_KING"></i>
		<i class="community_duke_small_flat_black" ng-if="otherPlayerRole == Player.KINGDOM_ROLE_DUKE"></i>
	</div>
	<div class="controls">
		<i class="control"
		   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"
		   clickable="closeChat()"
		   tooltip tooltip-translate="Button.Close"
		   ng-class="{action_cancel_tiny_flat_black: !cancelHover, action_cancel_tiny_flat_green: cancelHover}"></i>
		<i class="control"
		   on-pointer-over="minimizeHover = true" on-pointer-out="minimizeHover = false"
		   clickable="minimizeChat()"
		   tooltip tooltip-translate="Window.Minimize"
		   ng-class="{window_minimize_tiny_flat_black: !minimizeHover, window_minimize_tiny_flat_green: minimizeHover}"></i>
		<i class="control"
		   ng-if="chatInfo.data.isDocked"
		   on-pointer-over="undockHover = true" on-pointer-out="undockHover = false"
		   clickable="unDockChatWindow()"
		   tooltip tooltip-translate="Window.Undock"
		   ng-class="{window_undock_tiny_flat_black: !undockHover, window_undock_tiny_flat_green: undockHover}"></i>
		<i class="control"
		   ng-if="!chatInfo.data.isDocked"
		   on-pointer-over="dockHover = true" on-pointer-out="dockHover = false"
		   clickable="dockChatWindow()"
		   tooltip tooltip-translate="Window.Dock"
		   ng-class="{window_dock_tiny_flat_black: !dockHover, window_dock_tiny_flat_green: dockHover}"></i>
	</div>
	<div class="options" more-dropdown more-dropdown-options="getPrivateChatRoomOptions({{chatInfo.data.chatUser.data.playerId}}, '{{chatInfo.data.roomId}}')"></div>
</div></script>
<script type="text/ng-template" id="tpl/chat/partials/chatRoomMember.html"><div class="chatMember" clickable="clickPlayerAvatar({{member.data.playerId}})"
	 tooltip tooltip-data="playerName:{{member.data.name}}" tooltip-show="{{showTooltip}}"
	 tooltip-translate-switch="{
				'Chat.Status.PlayerOnline': {{memberForOnlineStatus.data.status === ChatUser.STATUS_ONLINE}},
				'Chat.Status.PlayerAFK': {{memberForOnlineStatus.data.status === ChatUser.STATUS_AFK}},
				'Chat.Status.PlayerOffline': {{memberForOnlineStatus.data.status === ChatUser.STATUS_OFFLINE}},
				'Chat.Status.PlayerNA': {{memberForOnlineStatus.data.status === ChatUser.STATUS_NOT_AVAILABLE}}
			 }"
	 ng-class="{prestige: showPrestige}">
	<div class="playerBox">
		<avatar-image class="playerAvatar" scale="0.45" player-id="{{member.data.playerId}}"></avatar-image>
	</div>
	<i class="chatStatus" ng-if="memberForOnlineStatus.data.status !== ChatUser.STATUS_NOT_AVAILABLE" ng-class="{
				chat_status_offline_tiny_illu: memberForOnlineStatus.data.status === ChatUser.STATUS_OFFLINE,
				chat_status_online_tiny_illu: memberForOnlineStatus.data.status === ChatUser.STATUS_ONLINE,
				chat_status_afk_tiny_illu: memberForOnlineStatus.data.status === ChatUser.STATUS_AFK
			}"></i>
	<div class="prestigeStars" ng-if="showPrestige">
		<prestige-stars playerId="{{member.data.playerId}}" size="tiny"></prestige-stars>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/chat/partials/chatWindowBody.html"><div class="chatBody" scrollable scroll-down scroll-position="{{chatScrollPosition}}" dropable="checkDrop(object)" ng-if="room.chatRoom.data.joined !== 0">
	<ul>
		<li class="divider loadOlder" ng-if="chatLines.data.length > 0 && !haveFirst">
			<span class="decorLine"><a translate clickable="loadOlder()">Chat.LoadOlderMessages</a></span>
		</li>
		<li ng-repeat-start="inboxLine in (orderedData = (displayedChatLines | orderBy:'data.timestamp')) as repeatList track by $index">
			<chat-time-divider last="{{::orderedData[$index-1].data.timestamp}}" current="{{::inboxLine.data.timestamp}}" reverse="true"></chat-time-divider>
		</li>
		<li class="unreadInfo" ng-if="room.unreadLines > 2 && indexOfFirstUnreadLine == $index">
			<span translate data="unreadLines: {{room.unreadLines}}">Chat.UnreadInfo.NewMessages</span>
		</li>
		<li ng-repeat-end class="line" ng-class="{
				currentPlayer: player.data.playerId == inboxLine.data.playerId,
				otherPlayer: player.data.playerId != inboxLine.data.playerId,
				new: indexOfFirstUnreadLine !== -1 && indexOfFirstUnreadLine <= $index
			}">
			<chat-room-member ng-if="player.data.playerId !== inboxLine.data.playerId" player-id="{{inboxLine.data.playerId}}" private-chat-mode="{{isPrivateChat}}"></chat-room-member>
			<div class="lineHead">
				<span class="name truncated" ng-if="player.data.playerId != inboxLine.data.playerId">{{::inboxLine.data.playerName }}</span>
				<div class="options" ng-if="::inboxLine.data.playerId != player.data.playerId"
					 more-dropdown more-dropdown-options="getPlayerOptions({{inboxLine.data.playerId}})"></div>
				<span ng-if="($root.currentServerTime - (inboxLine.data.timestamp / 1000)) < 60" class="date" translate>Chat.Time.JustNow</span>
				<span ng-if="($root.currentServerTime - (inboxLine.data.timestamp / 1000)) >= 60 && ($root.currentServerTime - (inboxLine.data.timestamp / 1000)) < 3600" class="date" i18ndt="{{::inboxLine.data.timestamp / 1000 }}" relative="from"></span>
				<span ng-if="($root.currentServerTime - (inboxLine.data.timestamp / 1000)) >= 3600 && ($root.currentServerTime - (inboxLine.data.timestamp / 1000)) < 172800" class="date" i18ndt="{{::inboxLine.data.timestamp / 1000 }}" format="shortTime"></span>
				<span ng-if="($root.currentServerTime - (inboxLine.data.timestamp / 1000)) >= 172800" class="date" i18ndt="{{::inboxLine.data.timestamp / 1000 }}" format="shortDate"></span>
			</div>
			<div class="lineBody" ng-repeat="text in inboxLine.data.text track by $index" user-text-parse="inboxLine.data.text[$index]" ng-class="{samePlayerAndTime: $index > 0}" parse="decorations;linkings;reports;coordinates" room-id="{{::room.roomId}}"></div>
		</li>
		<li ng-repeat="line in room.unsentLines">
			<div class="line unsentLine currentPlayer">
				{{line.data.playerName}} <span i18ndt="{{line.data.timestamp / 1000}}" format="short"></span>
				{{line.data.text}}
			</div>
		</li>
	</ul>
</div>
<div class="askForDesktopNotification" ng-if="displayDesktopNotificationInfo">
	<div class="confirmQuestion" translate>DesktopNotifications.Chat.ConfirmationQuestion</div>
	<button class="cancel" clickable="cancelDisplayDesktopNotification()">
		<span translate>Button.Cancel</span>
	</button>
	<button class="acceptButton" clickable="acceptDisplayDesktopNotification()">
		<span translate>Button.Accept</span>
	</button>
</div>
<div class="inputWrapper">
	<i class="writeMessage"></i>
	<textarea ng-disabled="isBannedFromMessaging" ng-if="isBannedFromMessaging" ng-attr-placeholder="{{answerPlaceholder}}" class="chatInput"></textarea>
	<textarea ng-disabled="!isActivated" ng-if="!isActivated && !isBannedFromMessaging" ng-attr-placeholder="{{isActivatedAnswerPlaceholder}}" class="chatInput"></textarea>
	<textarea ng-if="!isBannedFromMessaging && isActivated" ng-disabled="room.chatRoom.data.joined === 0 && !ChatRoom.isPrivate('{{::room.roomId}}')" inline-auto-complete autocompletedata="player,village,alliance,coords,emptyCoords" ng-attr-placeholder="{{inputPlaceholder}}" class="chatInput" chat-input send-function="send" room-id="{{room.roomId}}" dropable="checkDrop(object)"></textarea>
</div></script>
<script type="text/ng-template" id="tpl/chat/partials/disconnectedTooltip.html"><h6 class="error" translate>Chat.NotConnectedTitle</h6>
<div class="horizontalLine"></div>
<span translate>Chat.NotConnected</span>
</script>
<script type="text/ng-template" id="tpl/chat/partials/roomNameWithIcon.html"><span ng-if="online == true">
	<online-status text="Alliance.Role_{{allianceRights}}"
				   icon-class="community_{{role}}_small_flat"
				   status="1"></online-status>
</span>
<span ng-if="online != true">
	<online-status text="Alliance.Role_{{allianceRights}}"
				   icon-class="community_{{role}}_small_flat"
				   status="{{lastClick}}"></online-status>
</span>
{{roomName}}</script>
<script type="text/ng-template" id="tpl/chat/partials/typingNotificationTooltip.html"><span translate data="playerId:{{playerId}}">Chat.TypingNotification</span></script>
<script type="text/ng-template" id="tpl/cheatSheet/cheatSheet.html"><div ng-controller="cheatSheetCtrl" class="cheatSheet">
	<div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/overlay/cheatSheetOverlay.html">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Sed haec quis possit intrepidus aestimare tellus. Quis aute iure reprehenderit in voluptate velit esse. Nihilne te nocturnum praesidium Palati, nihil urbis vigiliae. Quisque placerat facilisis egestas cillum dolore.
Magna pars studiorum, prodita quaerimus. Integer legentibus erat a ante historiarum dapibus. Quis aute iure reprehenderit in voluptate velit esse. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua.

<div class="buttonFooter">
	<div class="error">Error message</div>
	<button clickable="closeOverlay()">Button 1</button>
	<button clickable="closeOverlay()">Button 2</button>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/overlay/cheatSheetOverlayCustom.html"><div class="inWindowPopup">
	<div class="inWindowPopupHeader">
		<div class="navigation">
			<a class="back"
			   clickable="back()"
			   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
				<i ng-class="{
						symbol_arrowFrom_tiny_flat_black: !fromHover,
						symbol_arrowFrom_tiny_flat_green: fromHover
					}"></i>
				<span translate>Navigation.Back</span>
			</a>
			|
			<a class="forward"
			   clickable="forward()"
			   on-pointer-over="toHover = true" on-pointer-out="toHover = false">
				<span translate>Navigation.Forward</span>
				<i ng-class="{
						symbol_arrowTo_tiny_flat_black: !toHover,
						symbol_arrowTo_tiny_flat_green: toHover
					}"></i>
			</a>
		</div>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Sed haec quis possit intrepidus aestimare tellus. Quis aute iure reprehenderit in voluptate velit esse. Nihilne te nocturnum praesidium Palati, nihil urbis vigiliae. Quisque placerat facilisis egestas cillum dolore.
		Magna pars studiorum, prodita quaerimus. Integer legentibus erat a ante historiarum dapibus. Quis aute iure reprehenderit in voluptate velit esse. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
	</div>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/overlay/cheatSheetOverlayWarning.html">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Sed haec quis possit intrepidus aestimare tellus. Quis aute iure reprehenderit in voluptate velit esse. Nihilne te nocturnum praesidium Palati, nihil urbis vigiliae. Quisque placerat facilisis egestas cillum dolore.
Magna pars studiorum, prodita quaerimus. Integer legentibus erat a ante historiarum dapibus. Quis aute iure reprehenderit in voluptate velit esse. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua.

<div class="buttonFooter">
	<div class="error">Error message</div>
	<button clickable="closeOverlay()">Button 1</button>
	<button clickable="closeOverlay()">Button 2</button>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/tabs/Buttons.html"><div expandable-content header-text="CheatSheet.TextButtons">
	<div class="buttons">
		<h5>Default Button</h5>
		<button>Normal Button</button><br/>
		<button class="disabled">Disabled Button</button><br/>

		<h5>Premium Button (without price)</h5>
		<button class="premium">Premium Button</button><br/>
		<button class="premium disabled">Disabled Premium Button</button><br/>
		<button class="premium optional">Optional Premium Button</button>

		<h5>Premium Button (with price)</h5>
		<button class="premium" price="2">Premium Button</button><br/>
		<button class="premium disabled" price="2">Disabled Premium Button</button><br/>
		<button class="premium optional" price="2">Optional Premium Button</button>

		<h5>Cancel Button</h5>
		<button class="cancel">Cancel Button</button><br/>
		<button class="cancel disabled">Disabled Cancel Button</button>
	</div>
</div>

<div expandable-content header-text="CheatSheet.HudButtons">
	<div class="buttonExample">
		<div class="mainLayoutMenuButton directionDown"></div>
		<div class="mainLayoutMenuButton directionUp"></div>
		<div class="mainLayoutMenuButton directionFrom"></div>
		<div class="mainLayoutMenuButton directionTo"></div>
	</div>
	<div class="buttonExample">
		<div class="mainLayoutMenuButton directionDown withArrowTip"></div>
		<div class="mainLayoutMenuButton directionUp withArrowTip"></div>
		<div class="mainLayoutMenuButton directionFrom withArrowTip"></div>
		<div class="mainLayoutMenuButton directionTo withArrowTip"></div>
	</div>
	<div class="buttonExample">
		<div class="mainLayoutMenuButton directionDown withArrowTip"><div class="arrowEnding"></div></div>
		<div class="mainLayoutMenuButton directionUp withArrowTip"><div class="arrowEnding"></div></div>
		<div class="mainLayoutMenuButton directionFrom withArrowTip"><div class="arrowEnding"></div></div>
		<div class="mainLayoutMenuButton directionTo withArrowTip"><div class="arrowEnding"></div></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/tabs/Colors.html"><div class="colors">
	<div class="colorBlock" ng-repeat="(id, colorBlock) in colorOverview track by id">
		<div class="color" ng-repeat="color in colorBlock">
			<div class="example" style="background-color: {{color.hex}}"></div>
			<div class="name">
				{{color.name}}<br>
				<span class="color">{{color.hex}}</span>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/tabs/Icons.html"><div class="icons">
	<table>
		<thead>
			<th colspan="3">
			</th>
		</thead>
		<tbody>
			<tr ng-repeat="(icon, size) in icons track by icon">
				<td class="class">{{icon}}</td>
				<td class="size">{{size}}</td>
				<td class="icon">
					<i class="{{icon}}"></i>
				</td>
			</tr>
		</tbody>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/tabs/Modules.html"><div class="modules">
<div expandable-content header-text="CheatSheet.WindowOverlay">
	<a clickable="openOverlay('cheatSheetOverlay')">open overlay</a><br>
	<a clickable="openOverlay('cheatSheetOverlayWarning')">open warning overlay</a><br>
	<a clickable="openOverlay('cheatSheetOverlayCustom')">open overlay with custom template</a>
</div>

<div expandable-content header-text="CheatSheet.ContentBoxes">
	<h5>Content box</h5>

	<div class="contentBoxes">
		<div class="contentBox">
			<div class="contentBoxHeader">
				contentBoxHeader
				<i class="action_edit_small_flat_black headerButton" clickable=""></i>
			</div>
			<div class="contentBoxBody">
				contentBoxBody<br/>
				Petierunt uti sibi concilium totius Galliae in diem certam indicere. Excepteur sint obcaecat cupiditat non proident culpa. Phasellus laoreet lorem vel dolor tempus vehicula. Quid securi etiam tamquam eu fugiat nulla pariatur. Quam diu etiam furor iste tuus nos eludet?
			</div>
			<div class="contentBoxFooter">
				contentBoxFooter
			</div>
		</div>

		<div class="contentBox">
			<div class="contentBoxHeader">
				contentBoxHeader
				<i class="action_edit_small_flat_black headerButton" clickable=""></i>
			</div>
			<div class="contentBoxBody" scrollable>
				contentBoxBody<br/>
				Petierunt uti sibi concilium totius Galliae in diem certam indicere. Excepteur sint obcaecat cupiditat non proident culpa. Phasellus laoreet lorem vel dolor tempus vehicula. Quid securi etiam tamquam eu fugiat nulla pariatur. Quam diu etiam furor iste tuus nos eludet?
				Morbi odio eros, volutpat ut pharetra vitae, lobortis sed nibh. Curabitur blandit tempus ardua ridiculus sed magna. Plura mihi bona sunt, inclinet, amari petere vellent. Quam temere in vitiis, legem sancimus haerentia. Quis aute iure reprehenderit in voluptate velit esse.
			</div>
			<div class="contentBoxFooter">
				contentBoxFooter
			</div>
		</div>

		<div class="contentBox">
			<div class="contentBoxBody">
				contentBoxBody<br/>
				Petierunt uti sibi concilium totius Galliae in diem certam indicere. Excepteur sint obcaecat cupiditat non proident culpa. Phasellus laoreet lorem vel dolor tempus vehicula. Quid securi etiam tamquam eu fugiat nulla pariatur. Quam diu etiam furor iste tuus nos eludet?
			</div>
		</div>
	</div>
</div>

<div expandable-content header-text="CheatSheet.Tables">
	<div class="tableExample">
		<h5>table</h5>
		<table>
			<thead>
				<tr>
					<th>thead th</th>
					<th>thead th</th>
					<th>thead th</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr class="highlighted">
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="tableExample">
		<h5>table .transparent</h5>
		<table class="transparent">
			<thead>
				<tr>
					<th>thead th</th>
					<th>thead th</th>
					<th>thead th</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="tableExample">
		<h5>table .columnOnly</h5>
		<table class="columnOnly">
			<thead>
				<tr>
					<th>thead th</th>
					<th>thead th</th>
					<th>thead th</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="tableExample">
		<h5>Fixed Table Header</h5>
		<table class="fixedTableHeader" scrollable>
			<thead>
				<tr>
					<th>thead th</th>
					<th>thead th</th>
					<th>thead th</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr class="highlighted">
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
			</tbody>
		</table>

	</div>

	<div class="tableExample">
		<h5>table .rowOnly</h5>
		<table class="rowOnly">
			<thead>
				<tr>
					<th>thead th</th>
					<th>thead th</th>
					<th>thead th</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div expandable-content header-text="CheatSheet.FormElements">
	<div class="example">
		<div class="formContainer">
			<h5>Dropdown normal and disabled</h5>
			<div dropdown data="dropdown"></div>
			<br><br>
			<div dropdown data="dropdownDisabled"></div>
		</div>
		<div class="formContainer">
			<h5>Dropdown resized</h5>
			<div dropdown data="dropdownWideHeader"></div>
			<br><br>
			<div dropdown data="dropdownNarrowHeader"></div>
		</div>
		<div class="formContainer">
			<h5>dropdown .doubleBorder</h5>
			<div dropdown class="doubleBorder" data="dropdown"></div>
		</div>
	</div>

	<div class="example">
		<h5>Input field normal and disabled</h5>
		<input type="text" placeholder="Insert text"/><br><br>
		<input ng-disabled="true" type="text" placeholder="Can't insert text"/>
	</div>

	<div class="example">
		<div class="formContainer">
			<h5>Checkbox normal and disabled</h5>
			<label><input type="checkbox" checked/>Click me</label>
			<label><input type="checkbox"/>And meeeeeeeeeee</label>
			<label><input disabled="disabled" type="checkbox"/>Can't click me</label>
			<label><input disabled="disabled" type="checkbox" checked/>Can't click me again</label>
		</div>
		<div class="formContainer">
			<h5>Radio normal and disabled</h5>
			<label><input name="select" type="radio" checked/>Click me</label>
			<label><input name="select" type="radio"/>No! Click meeee!</label>
			<label><input ng-disabled="true" name="noselect" type="radio"/>Can't click me</label>
			<label><input ng-disabled="true" name="noselect" type="radio" checked/>Can't click me again</label>
		</div>
	</div>

	<div class="example">
		<h5>Switch</h5>
		<switch switch-name1="No" switch-name2="Yes"></switch>
	</div>

	<div class="example">
		<h5>Slider normal, with steps, locked ans disabled</h5>
		<slider slider-min="0" slider-max="233" slider-data="sliderData1" slider-show-max-button="false"></slider>
		<slider slider-min="0" slider-max="1000" slider-data="sliderData2"></slider>
		<slider slider-min="0" slider-max="1000" slider-steps="100" slider-data="sliderData3"></slider>
		<slider slider-min="0" slider-max="1000" slider-lock="true" slider-data="sliderData4"></slider>
		<slider slider-min="0" slider-max="1000" slider-lock="true" slider-data="sliderData4" class="disabled"></slider>
	</div>
</div>

<div expandable-content header-text="CheatSheet.UsabilityElements">
	<h5>Filter</h5>

	<div class="filterBar">
		<div class="filterGroup">
			<a class="filter selected">
				<i class="unit_consumption_small_flat_black"></i>
			</a>
			<a class="filter">
				<i class="unit_population_small_illu"></i>
			</a>
			<a class="filter selected">
				<i class="unit_gold_small_illu"></i>
			</a>

			<div class="subFilter">
				<a class="filter">
					<i class="unit_wood_small_illu"></i>
				</a>
				<a class="filter selected">
					<i class="unit_clay_small_illu"></i>
				</a>
				<a class="filter">
					<i class="unit_iron_small_illu"></i>
				</a>
				<a class="filter">
					<i class="unit_crop_small_illu"></i>
				</a>
			</div>
		</div>
	</div>

	<h5>Pagination with start position</h5>
	<div pagination class="paginated"
				current-page="currentPage"
				items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				display-page-func="displayCurrentPage"
				startup-position="{{startPosition}}"
				route-named-param="cp">
		<table>
			<tr ng-repeat="n in rows">
				<td>{{n}}</td>
			</tr>
		</table>
	</div>

	<h5>Progress Bars</h5>
	<div progressbar perc="40" additional-perc="20" label="40 + 20"></div>
	<div progressbar perc="40" marker="60" label="40/60"></div>
	<div progressbar duration="{{duration}}" finish-time="{{finishTime}}" show-countdown="true"></div>
	<div class="progressBarContainer">
		<div progressbar value="{{progressValue}}" max-value="1000" value-interpolation="true" label-icon="unit_wood_medium_illu" gain-animation-icon="animation_wood_large_illu"
					 on-interpolation-end="progressValue ? progressValue = 0 : progressValue = 1000"></div>
	</div>

	<h5>Arrow Container</h5>

	<div class="arrowContainer arrowDirectionTo">
		<span class="arrowInside">1</span>
		<span class="arrowOutside"></span>
	</div>
	<div class="arrowContainer arrowDirectionTo active">
		<span class="arrowInside">2</span>
		<span class="arrowOutside">active</span>
	</div>
	<div class="arrowContainer arrowDirectionTo disabled">
		<span class="arrowInside">3</span>
		<span class="arrowOutside">disabled</span>
	</div>
	<div class="arrowContainer arrowDirectionTo disabled locked">
		<span class="arrowInside">4</span>
			<span class="arrowOutside">
				<div class="symbol_lock_small_wrapper">
					<i class="symbol_lock_small_flat_black"></i>
				</div>
				disabled locked
			</span>
	</div>
	<div class="arrowContainer arrowDirectionFrom active">
		<span class="arrowInside">5</span>
		<span class="arrowOutside fullCentered">fullCentered</span>
	</div>
</div>

<div expandable-content header-text="CheatSheet.Clickables">
	<div class="example">
		<h5>.clickableContainer</h5>
		<a class="clickableContainer">
			normal<br>
			hover<br>
			click
		</a>
		<a class="clickableContainer active">
			active
		</a>
		<a class="clickableContainer disabled">
			disabled
		</a>
	</div>
	<div class="example">
		<h5>.clickableContainer.active .selectionArrow</h5>

		<div class="optionContainer" ng-init="ccOption = 'A'">
			<a class="clickableContainer" clickable="ccOption = 'A'" ng-class="{active: ccOption == 'A'}">
				Option A
				<div class="selectionArrow" ng-if="ccOption == 'A'"></div>
			</a>
			<a class="clickableContainer" clickable="ccOption = 'B'" ng-class="{active: ccOption == 'B'}">
				Option B
				<div class="selectionArrow" ng-if="ccOption == 'B'"></div>
			</a>
		</div>
		<div class="contentContainer">Content {{ccOption}}</div>
	</div>

	<div class="example">
		<h5>.entityBox</h5>
		<a class="entityBox">
			<i class="cheatItem"></i>
		</a>normal, hover, click

		<a class="entityBox active">
			<i class="cheatItem"></i>
		</a>active

		<a class="entityBox" draggable>
			<i class="cheatItem"></i>
		</a>drag
	</div>

	<div class="example">
		<div class="iconButtons">
			<h5>.iconButton</h5>
			<a class="iconButton">
				<i class="unit_crop_small_illu"></i>
			</a> normal, hover, click
			<a class="iconButton active">
				<i class="unit_crop_small_illu"></i>
			</a> active
			<a class="iconButton disabled">
				<i class="unit_crop_small_illu"></i>
			</a> disabled
		</div>
		<div class="iconButtons">
			<h5>.iconButton .premium</h5>
			<a class="iconButton premium">
				<i class="feature_npcTrader_small_flat_black"></i>
			</a> normal, hover, click
			<a class="iconButton premium disabled">
				<i class="feature_npcTrader_small_flat_black"></i>
			</a> disabled
		</div>
		<div class="iconButtons">
			<h5>.iconButton .doubleBorder</h5>
			<a class="iconButton doubleBorder">
				<i class="symbol_plus_tiny_flat_black"></i>
			</a> normal, hover, click
			<a class="iconButton doubleBorder active">
				<i class="symbol_plus_tiny_flat_black"></i>
			</a> active
			<a class="iconButton doubleBorder disabled">
				<i class="symbol_plus_tiny_flat_black"></i>
			</a> disabled
		</div>
	</div>

	<div class="example">
		<div class="iconButtons">
			<h5>.iconButton .doubleBorder .arrowDirectionFrom</h5>
			<a class="iconButton doubleBorder arrowDirectionFrom">
				<i class="symbol_minus_tiny_flat_black"></i>
			</a> normal, hover, click
			<a class="iconButton doubleBorder arrowDirectionFrom active">
				<i class="symbol_minus_tiny_flat_black"></i>
			</a> active
			<a class="iconButton doubleBorder arrowDirectionFrom disabled">
				<i class="symbol_minus_tiny_flat_black"></i>
			</a> disabled
		</div>
		<div class="iconButtons">
			<h5>.iconButton .doubleBorder .arrowDirectionTo</h5>
			<a class="iconButton doubleBorder arrowDirectionTo">
				<i class="symbol_plus_tiny_flat_black"></i>
			</a> normal, hover, click
			<a class="iconButton doubleBorder arrowDirectionTo active">
				<i class="symbol_plus_tiny_flat_black"></i>
			</a> active
			<a class="iconButton doubleBorder arrowDirectionTo disabled">
				<i class="symbol_plus_tiny_flat_black"></i>
			</a> disabled
		</div>
	</div>
</div>

<div expandable-content header-text="CheatSheet.Layout">
	<div class="truncateExamples">
		<h5>Truncate</h5>

		<div class="contentBox">
			<div class="contentBoxBody truncated">
				truncate<br/>
				Petierunt uti sibi concilium totius Galliae in diem certam indicere. Excepteur sint obcaecat cupiditat non proident culpa. Phasellus laoreet lorem vel dolor tempus vehicula. Quid securi etiam tamquam eu fugiat nulla pariatur. Quam diu etiam furor iste tuus nos eludet?
			</div>
		</div>

		<h5>Truncate small box</h5>

		<div class="contentBox smaller">
			<div class="contentBoxBody truncated">
				truncate with smaller box<br/>
				Petierunt uti sibi concilium totius Galliae in diem certam indicere. Excepteur sint obcaecat cupiditat non proident culpa. Phasellus laoreet lorem vel dolor tempus vehicula. Quid securi etiam tamquam eu fugiat nulla pariatur. Quam diu etiam furor iste tuus nos eludet?
			</div>
		</div>

		<h5>Truncate in table and player-link</h5>
		<table>
			<thead>
				<tr>
					<th>thead th</th>
					<th>thead th</th>
					<th>thead th</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
				<tr class="highlighted">
					<th>tbody th</th>
					<td>
						<div class="truncated">something much much too long Petierunt uti sibi concilium totius Galliae in diem certam indicere</div>
					</td>
					<!--<td>tbody td</td>-->
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>
						<span player-link playerId="100" playerName="something much much too long Petierunt uti sibi concilium totius Galliae in diem certam indicere"></span>
					</td>
					<td>tbody td</td>
				</tr>
				<tr>
					<th>tbody th</th>
					<td>tbody td</td>
					<td>tbody td</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</div></script>
<script type="text/ng-template" id="tpl/cheatSheet/tabs/Styles.html"><div class="styles">
	<div expandable-content header-text="CheatSheet.ContentBox">
		<div class="contentBoxes">
			<div class="example">
				<h5>.contentBox</h5>
				<div class="contentBox">
					<div class="contentBoxHeader">
						contentBoxHeader
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
					<div class="contentBoxBody">
						contentBoxBody
					</div>
					<div class="contentBoxFooter">
						contentBoxFooter
					</div>
				</div>
			</div>

			<div class="example">
				<h5>.contentBox .colored</h5>
				<div class="contentBox colored">
					<div class="contentBoxHeader">
						contentBoxHeader
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
					<div class="contentBoxBody">
						contentBoxBody
					</div>
					<div class="contentBoxFooter">
						contentBoxFooter
					</div>
				</div>
			</div>

			<div class="example">
				<h5>.contentBox .gradient</h5>
				<div class="contentBox gradient">
					<div class="contentBoxHeader">
						contentBoxHeader
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
					<div class="contentBoxBody">
						contentBoxBody
					</div>
					<div class="contentBoxFooter">
						contentBoxFooter
					</div>
				</div>
			</div>

			<div class="example">
				<h5>.contentBox .gradient .double</h5>
				<div class="contentBox gradient double">
					<div class="contentBoxHeader">
						contentBoxHeader
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
					<div class="contentBoxBody">
						contentBoxBody
					</div>
					<div class="contentBoxFooter">
						contentBoxFooter
					</div>
				</div>
			</div>

			<div class="example">
				<h5>.contentBox .transparent</h5>
				<div class="contentBox transparent">
					<div class="contentBoxHeader">
						contentBoxHeader
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
					<div class="contentBoxBody">
						contentBoxBody
					</div>
					<div class="contentBoxFooter">
						contentBoxFooter
					</div>
				</div>
			</div>
		</div>
	</div>

	<div expandable-content header-text="CheatSheet.Header">
		<div class="example example1">
			<div class="separate">
				<h5>separate colored header</h5>
				<h6 class="headerColored">
					.headerColored
					<i class="action_edit_small_flat_black headerButton" clickable=""></i>
				</h6>
				Lorem ipsum dolor sit amet, ...
			</div>

			<div class="inBox">
				<h5>colored header in contentBox</h5>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerColored">
						.headerColored
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>

			<div class="inBox">
				<h5>colored header in transparent contentBox</h5>
				<div class="contentBox transparent">
					<h6 class="contentBoxHeader headerColored">
						.headerColored
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>
		</div>

		<div class="horizontalLine"></div>

		<div class="example example2">
			<div class="separate">
				<h5>separate header with icon</h5>
				<h6 class="headerWithIcon arrowDirectionDown">
					<i class="community_alliance_medium_flat_black"></i>
					.headerWithIcon .arrowDirectionDown
					<i class="action_edit_small_flat_black headerButton" clickable=""></i>
				</h6>
				Lorem ipsum dolor sit amet, ...
				<h6 class="headerWithIcon arrowDirectionTo">
					<i class="community_kingdom_medium_flat_black"></i>
					.headerWithIcon .arrowDirectionTo
					<i class="action_edit_small_flat_black headerButton" clickable=""></i>
				</h6>
				Lorem ipsum dolor sit amet, ...
				<h6 class="headerWithIcon arrowDirectionFrom">
					<i class="community_secretSociety_medium_flat_black"></i>
					.headerWithIcon .arrowDirectionFrom
					<i class="action_edit_small_flat_black headerButton" clickable=""></i>
				</h6>
				Lorem ipsum dolor sit amet, ...
			</div>

			<div class="inBox">
				<h5>header with icon in contentBox</h5>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
						<i class="community_friend_medium_flat_black"></i>
						.contentBoxHeader .headerWithIcon .arrowDirectionDown
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerWithIcon arrowDirectionTo">
						<i class="action_check_medium_flat_black"></i>
						.contentBoxHeader .headerWithIcon .arrowDirectionTo
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>

			<div class="inBox">
				<h5>header with icon in transparent contentBox</h5>
				<div class="contentBox transparent">
					<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
						<i class="action_search_medium_flat_black"></i>
						.contentBoxHeader .headerWithIcon .arrowDirectionDown
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
				<div class="contentBox transparent">
					<h6 class="contentBoxHeader headerWithIcon arrowDirectionTo">
						<i class="action_check_medium_flat_black"></i>
						.contentBoxHeader .headerWithIcon .arrowDirectionTo
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>
		</div>

		<div class="horizontalLine"></div>

		<div class="example example3">
			<div class="separate">
				<h5>separate header with arrow endings</h5>
				<h6 class="headerWithArrowEndings">
					<div class="content">
						.headerWithArrowEndings
					</div>
				</h6>
				<h6 class="headerWithArrowEndings glorious">
					<div class="content">
						.headerWithArrowEndings .glorious
					</div>
				</h6>
				<h6 class="headerWithArrowEndings goldenEnding">
					<div class="content">
						.headerWithArrowEndings .golden
					</div>
				</h6>
				<h6 class="headerWithArrowEndings golden">
					<div class="content">
						.headerWithArrowEndings .treasure
					</div>
				</h6>
			</div>

			<div class="inBox">
				<h5>header with arrow endings in contentBox</h5>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerWithArrowEndings">
						<div class="content">
							.contentBoxHeader .headerWithArrowEndings
						</div>
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerWithArrowEndings glorious">
						<div class="content">
							.contentBoxHeader .headerWithArrowEndings .glorious
						</div>
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>

			<div class="inBox">
				<h5>header with arrow endings in transparent contentBox</h5>
				<div class="contentBox transparent">
					<h6 class="contentBoxHeader headerWithArrowEndings">
						<div class="content">
							.contentBoxHeader .headerWithArrowEndings
						</div>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
				<div class="contentBox transparent">
					<h6 class="contentBoxHeader headerWithArrowEndings glorious">
						<div class="content">
							.contentBoxHeader .headerWithArrowEndings .glorious
						</div>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>
		</div>

		<div class="horizontalLine"></div>

		<div class="example example4">
			<div class="separate">
				<h5>separate trapezoidal header</h5>
				<h6 class="headerTrapezoidal">
					<div class="content">
						.headerTrapezoidal
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
				</h6>
				Lorem ipsum dolor sit amet, ...
				<h6 class="headerTrapezoidal bright">
					<div class="content">
						.headerTrapezoidal .bright
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</div>
				</h6>
				Lorem ipsum dolor sit amet, ...
			</div>

			<div class="inBox">
				<h5>trapezoidal header in contentBox</h5>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerTrapezoidal">
						<div class="content">
							.contentBoxHeader .headerTrapezoidal
							<i class="action_edit_small_flat_black headerButton" clickable=""></i>
						</div>
						<i class="action_edit_small_flat_black headerButton" clickable=""></i>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>

			<div class="inBox">
				<h5>trapezoidal header in transparent contentBox</h5>
				<div class="contentBox transparent">
					<h6 class="contentBoxHeader headerTrapezoidal">
						<div class="content">
							.contentBoxHeader .headerTrapezoidal
							<i class="action_edit_small_flat_black headerButton" clickable=""></i>
						</div>
					</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>
		</div>
		<div class="horizontalLine"></div>

		<div class="example example5">
			<div class="separate">
				<h5>separate header with arrow pointing down</h5>
				<h6 class="headerWithArrowDown">.headerWithArrowDown</h6>
				<h6 class="headerWithArrowDown active">.headerWithArrowDown .active</h6>
			</div>

			<div class="inBox">
				<h5>header with arrow pointing down in contentBox</h5>
				<div class="contentBox">
					<h6 class="contentBoxHeader headerWithArrowDown">.contentBoxHeader .headerWithArrowDown</h6>
					<div class="contentBoxBody">.contentBoxBody</div>
				</div>
			</div>
		</div>
	</div>

	<div expandable-content header-text="CheatSheet.Spacing">
		<div class="lineExamples">
			<div class="lineExample">
				<h5>.horizontalLine</h5>
				<div class="horizontalLine"></div>
				<h5>.horizontalLine .double</h5>
				<div class="horizontalLine double"></div>
			</div>
			<div class="lineExample">
				<h5>.verticalLine</h5>
				<div class="verticalLine"></div>
			</div>
			<div class="lineExample">
				<h5>.verticalLine .double</h5>
				<div class="verticalLine double"></div>
			</div>
		</div>
	</div>

	<div expandable-content header-Text="CheatSheet.Arrows">
		<h5>.indicationArrow</h5>
		<div class="arrowWrapper">
			<div class="indicationArrow"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/confirmGoldUsage/confirmGoldUsage.html"><div class="confirmGoldUsageContent" ng-controller="confirmGoldUsageCtrl">
	<i class="featureIcon {{::featureClass}}_medium_illu"></i>
	<div class="description" translate data="price:{{::actionPrice}}" options="{{::featureName}}">ConfirmGoldUsage.Description_?</div>
	<label ng-if="::skipable"><input type="checkbox" ng-model="$parent.doNotShowAgain"><span translate>ConfirmGoldUsage.DisableHint</span></label>
	<div ng-if="::(featureName == PremiumFeature.FEATURE_NAME_BOOK_BUILD_MASTER_SLOT)">
		<span class="activationHint" translate>ConfirmGoldUsage.MasterBuilderHint</span><br/><br/>
	</div>
	<div class="horizontalLine"></div>
	<div class="buttons">
		<button class="cancel" clickable="closeWindow('confirmGoldUsage')">
			<span translate>Button.Cancel</span>
		</button>
		<button ng-if="::confirmationRequestId" ng-class="{premium: actionPrice > 0}" clickable="confirm();" price="{{::actionPrice}}" play-on-click="false">
			<span translate>ConfirmGoldUsage.Button_Confirm</span>
		</button>
		<button ng-if="::!confirmationRequestId" class="premium"
				premium-feature="{{::featureName}}" clickable="saveAndClose();" price="{{::actionPrice}}" play-on-click="false">
			<span translate options="{{::(featureName == PremiumFeature.FEATURE_NAME_BOOK_BUILD_MASTER_SLOT) ? 'Unlock' : 'Confirm'}}">ConfirmGoldUsage.Button_?</span>
		</button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/coordinates/coordinates.html"><span>
	<a ng-if="hasLink" clickable="openPage('map', 'centerId', '{{link}}_{{currentServerTime}}');">
		<span class="coordinates coordinatesWrapper {{aligned}}">
			<span class="coordinateX">({{x}}</span>
			<span class="coordinatePipe">|</span>
			<span class="coordinateY">{{y}})</span>
		</span>
	</a>
	<span ng-if="!hasLink" class="coordinates coordinatesWrapper {{aligned}}">
		<span class="coordinateX">({{x}}</span>
		<span class="coordinatePipe">|</span>
		<span class="coordinateY">{{y}})</span>
	</span>
</span></script>
<script type="text/ng-template" id="tpl/directive/bbCodeInput.html"><div class="bbCodeInput">
	<div class="codes">
		<div class="iconButton" clickable="insertCode('[b]','[/b]')" ng-class="{disabled: preview}" tooltip tooltip-translate="BBCode.Bold">
			<i class="bbCode_bold_small_flat_black"></i>
		</div>
		<div class="iconButton" clickable="insertCode('[i]','[/i]')" ng-class="{disabled: preview}" tooltip tooltip-translate="BBCode.Italic">
			<i class="bbCode_italic_small_flat_black"></i>
		</div>
		<div class="iconButton" clickable="insertCode('[u]','[/u]')" ng-class="{disabled: preview}" tooltip tooltip-translate="BBCode.Underlined">
			<i class="bbCode_underline_small_flat_black"></i>
		</div>
		<div class="iconButton" clickable="insertCode('[s]','[/s]')" ng-class="{disabled: preview}" tooltip tooltip-translate="BBCode.Strikethrough">
			<i class="bbCode_strikeThrough_small_flat_black"></i>
		</div>
		<div class="iconButton" clickable="insertCode('[h]','[/h]')" ng-class="{disabled: preview}" tooltip tooltip-translate="BBCode.Highlight">
			<i class="bbCode_highlight_small_flat_black"></i>
		</div>
		<div class="iconButton" clickable="triggerSearch()" ng-class="{disabled: preview, active: searchOpened}" tooltip tooltip-translate="BBCode.Link">
			<i class="bbCode_addLink_small_flat_black"></i>
		</div>
		<div class="verticalLine"></div>
		<div class="iconButton" clickable="triggerPreview()" ng-class="{active: preview}" tooltip tooltip-translate="BBCode.Preview">
			<i class="bbCode_preview_small_flat_black"></i>
		</div>

		<div class="autocomplete" ng-show="searchOpened">
			<serverautocomplete autocompletedata="village,player,alliance,coords,emptyCoords"
								autocompletecb="searchCallback" ng-model="searchModel"></serverautocomplete>
		</div>
	</div>

	<textarea ng-model="localTextModel"
			  ng-show="!preview"
			  ng-attr-auto_focus="!preview"
			  dropable="checkDrop(object)" >
	</textarea>
	<div class="previewWrapper" ng-show="preview">
		<div class="preview"
			 ng-if="preview"
			 user-text-parse="localTextModel" parse="decorations;linkings;reports;coordinates" ></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/directive/playerProfile.html"><div class="playerProfile">
	<div class="detailsWrapper" ng-class="{king: playerRole == playerModel.KINGDOM_ROLE_KING, duke: playerRole == playerModel.KINGDOM_ROLE_DUKE}">
		<div class="contentBox gradient">
			<div class="flagHanger" ng-class="{king: playerRole == playerModel.KINGDOM_ROLE_KING, duke: playerRole == playerModel.KINGDOM_ROLE_DUKE}">
				<div class="flag"></div>
				<i class="community_governor_small_flat_black" ng-if="playerRole == playerModel.KINGDOM_ROLE_GOVERNOR"></i>
				<i class="community_king_small_flat_black" ng-if="playerRole == playerModel.KINGDOM_ROLE_KING"></i>
				<i class="community_duke_small_flat_black" ng-if="playerRole == playerModel.KINGDOM_ROLE_DUKE"></i>
			</div>
			<div class="contentBoxHeader headerWithArrowEndings" ng-class="{golden: playerRole == playerModel.KINGDOM_ROLE_KING, goldenEnding: playerRole == playerModel.KINGDOM_ROLE_DUKE}">
				<div class="content">{{playerData.name}}</div>
			</div>
			<div class="contentBoxBody">
				<div class="playerDetails">
					<div class="contentBox transparent">
						<div class="contentBoxHeader">
							<div translate options="{{playerRole}}">Player.Role_?</div>
							<i ng-if="::playerInfo.language && player.data.playerId != playerData.playerId" class="languageFlag {{::playerInfo.language}}" tooltip="{{::playerInfo.language}}"></i>
						</div>
						<div class="contentBoxBody">
							<div>
								<span class="desc" translate>TableHeader.Rank</span>
								<span class="data">{{playerInfo.populationRank|rank}}</span>
							</div>
							<div>
								<span class="desc" translate>TableHeader.Population</span>
								<span class="data">{{playerData.population}}</span>
							</div>
							<div>
								<span class="desc" translate>Villages</span>
								<span class="data">{{playerData.villages.length}}</span>
							</div>
							<div>
								<span class="desc" translate>TableHeader.Alliance</span>
									<span class="data">
										<span ng-if="playerData.allianceId == 0">-</span>
										<alliance-link ng-if="playerData.allianceId > 0" allianceId="{{playerData.allianceId}}"
														allianceName="{{playerData.allianceTag}}"></alliance-link>
									</span>
							</div>
							<div>
								<span class="desc" translate>TableHeader.Tribe</span>
								<span class="data" translate options="{{playerData.tribeId}}">Tribe_?</span>
							</div>
						</div>
					</div>
				</div>
				<div class="avatar">
					<div class="heroLevel">
						<span translate>HUD.Hero.Level</span>
						<br>
						<span>{{hero.data.level}}</span>
					</div>
					<div class="avatarLink" clickable="openOverlay('playerProfileFullImage', {'playerId': {{playerId}} });">
						<avatar-image scale="0.55" class="avatarImage" player-id="{{playerId}}" size="big" avatar-class="profileImage"></avatar-image>
						<div class="prestigeStars" ng-if="config.balancing.features.prestige">
							<prestige-stars stars="playerData.stars" size="tiny"></prestige-stars>
						</div>
					</div>

					<span class="decoration"></span>
					<div class="prestigeStarsTooltip"
						 tooltip
						 tooltip-translate-switch="{
								'Prestige.Stars.Tooltip.Own': {{!!player.data.nextLevelPrestige}},
								'Prestige.Stars.Tooltip.Own.Max': {{!player.data.nextLevelPrestige}}
							 }"
						 ng-if="myPlayerId == playerId && config.balancing.features.prestige"
						 clickable="openWindow('profile', {'playerId': playerId, 'profileTab': 'prestige'})"
						 tooltip-data="prestige:{{playerData.prestige}},nextLevelPrestige:{{playerData.nextLevelPrestige}}"></div>
					<div ng-if="myPlayerId != playerId && config.balancing.features.prestige"
						 class="prestigeStarsTooltip" tooltip tooltip-translate="Prestige.Stars.Tooltip.Other"></div>
				</div>
				<div class="kingdomDetails">
					<div class="background profile_kingdomBackground_layout"></div>
					<div class="contentBox transparent">
						<div class="contentBoxHeader">
							<span class="data" ng-if="playerData.kingdomId > 0" translate>Kingdom</span>
							<span class="data" ng-if="playerData.kingdomId == 0" translate>PlayerProfile.noKingdom</span>
						</div>
						<div class="contentBoxBody" ng-if="playerData.kingdomId > 0">
							<div ng-if="playerData.isKing!=true">
								<span class="desc" translate>Kingdom.Information.King</span>
								<span class="data"><span player-link playerId="{{playerData.kingdomId}}" playerName=""></span></span>
							</div>
							<div>
								<span class="desc" translate>Kingdom.Information.GovernatorCount</span>
								<span class="data">{{kingdomStats.governorCount || 0}}</span>
							</div>
							<div>
								<span class="desc" translate>Kingdom.Information.PopulationCount</span>
								<span class="data" ng-if="kingdomStats.population.score != null">{{kingdomStats.population.score|number:0}}</span>
								<span class="data" ng-if="kingdomStats.population.score == null">0</span>
							</div>
							<div>
								<span class="desc" translate>Kingdom.Information.TerritorySize</span>
								<span class="data" ng-if="kingdomStats.territory.score != null">{{kingdomStats.territory.score|number:0}} <span translate>TableHeader.Fields</span></span>
								<span class="data" ng-if="kingdomStats.territory.score == null">0 <span translate>TableHeader.Fields</span></span>
							</div>
							<div>
								<span class="desc" translate>Kingdom.Information.TreasureCount</span>
								<span class="data" ng-if="kingdomStats.treasures.rank != null">{{kingdomStats.treasures.score|number:0}}</span>
								<span class="data" ng-if="kingdomStats.treasures.rank == null">0</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/directive/questGiver.html"><div class="questGiver characters_{{QuestGiver.STRING[data.npcId]}}_medium_illu {{animation}}"
	 ng-class="{hover: questMarkerHover}"
	 ng-hide="data.dialog == -3"
	 on-pointer-over="questMarkerHover = true"
	 on-pointer-out="questMarkerHover = false"
	 clickable="startDialog({{data.npcId}}, {{data.questId}}, {{data.dialog}})"
	 tooltip tooltip-translate="QuestGiver_{{data.npcId}}">
	<div class="character">
		<div ng-if="data.marker != null">
			<div class="questMarker">
				<div class="questMarkerContent">
					<div class="questMarkerContentWrapper">
						<div class="questMarkerStatus"
							 ng-class="{'character_exclamation_mark_small': data.marker != 'status4' && !questMarkerHover,
										'character_question_mark_small': data.marker == 'status4' && !questMarkerHover,
										'characters_{{QuestGiver.STRING[data.npcId]}}_{{questGiverDirectionMapping[data.npcId]}}_small': questMarkerHover}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/directive/generalElements/button.html"><div class="content">
	<span ng-transclude></span>
	<span class="price gold" ng-if="price > 0 || forceGoldUsage"><i class="unit_gold_small_illu"></i>{{price}}</span>
	<span class="price voucher" ng-if="price == -1 && !forceGoldUsage"><i class="cardGame_prizePremium_small_illu"></i><span>1</span></span>
</div></script>
<script type="text/ng-template" id="tpl/directive/generalElements/numberAdjuster.html"><div class="numberAdjuster">
	<div class="decr iconButton doubleBorder" ng-class="{disabled: numberModel <= min}">
		<i class="symbol_minus_tiny_flat_black"></i>
	</div>
	<span class="numberAdjusterContent" ng-transclude></span>

	<div class="incr iconButton doubleBorder" ng-class="{disabled: numberModel >= max}">
		<i class="symbol_plus_tiny_flat_black"></i>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/directive/generalElements/progressbar.html"><div class="progressbar">
	<i ng-if="::labelIcon" class="labelIcon {{labelIcon}}"></i>
	<div class="progress">
		<div class="bar positive perc {{type}}"></div>
		<div class="bar additionalBar additionalPerc"></div>
		<div class="marker"></div>
		<div ng-if="::showCountdown" class="countdown" countdown="{{finishTimeTotal || finishTime}}"></div>
		<div ng-if="::label" class="label" ng-bind-html="label"></div>
		<div ng-if="::percTooltip" class="tooltipArea" tooltip="{{barTooltip}}"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/directive/generalElements/reward.html"><div ng-if="type == 1">
	<span class="rewardIcon"><i class="unit_experience_{{size}}_flat_black"></i></span>
	<span class="rewardText">{{value}} <span translate ng-if="size != 'small'">Hero.Experience</span></span>
</div>
<div ng-if="type == 2">
	<span class="rewardIcon"></span>
	<span class="rewardText">
		<display-resources ng-if="checkStorage" resources="value" check-storage="true" flying-res-trigger="flyingResTrigger"></display-resources>
		<display-resources ng-if="!checkStorage" resources="value"></display-resources>
	</span>
</div>
<div ng-if="type == 3">
	<div ng-repeat="(unitNr, amount) in value">
		<span class="rewardIcon"><span unit-icon data="{{tribeId}},{{unitNr}}"></span></span>
		<span class="rewardText">
			<span translate options="{{tribeId-1}}{{unitNr}}" ng-if="tribeId>1">Troop_?</span>
			<span translate options="{{unitNr}}" ng-if="tribeId==1">Troop_?</span>
			({{amount}}&times;)
		</span>
	</div>
</div>
<div ng-if="type == 4" tooltip tooltip-translate-switch="{Silver: size == 'small'}">
	<span class="rewardIcon"><i class="unit_silver_{{size}}_illu"></i></span>
	<span class="rewardText">{{value}} <span translate ng-if="size != 'small'">Silver</span></span>
</div>
<div ng-if="type == 5" class="rewardHeroItem">
	<span class="rewardIcon">
		<i class="heroItem_{{heroItems[value.itemType].images[0]}}_large_illu male"></i>
	</span>
	<span class="rewardText">
		<span translate options="{{value.itemType}}">Hero.Item_?</span>
		<span ng-if="value.amount > 1">({{value.amount}}&times;)</span>
	</span>
</div>
<div ng-if="type == 6">
	<span class="rewardIcon"></span>
	<span translate class="rewardText" options="{{value}}">Quest.Reward_?</span>
</div>
<div ng-if="type == 7">
	<span class="rewardIcon"><i class="unit_gold_{{size}}_illu"></i></span>
	<span class="rewardText">{{value}} <span translate ng-if="size != 'small'">Gold</span></span>
</div>
<div ng-if="type == 8">
	<span class="rewardIcon"><i class="unit_culturePoint_{{size}}_illu"></i></span>
	<span class="rewardText">{{value}} <span translate ng-if="size != 'small'">MainBuilding.CulturePoints</span></span>
</div>
<div ng-if="type == 9">
	<span class="rewardIcon"><i class="unit_treasure_{{size}}_illu"></i></span>
	<span class="rewardText">{{value}} <span translate ng-if="size != 'small'">Resource.Treasures</span></span>
</div>
<div ng-if="type == 10">
	<span class="rewardIcon"><i class="unit_adventurePoint_{{size}}_illu" tooltip tooltip-translate-switch="{'Adventures.AdventurePoints': size == 'small'}"></i></span>
	<span class="rewardText">{{value}} <span translate ng-if="size != 'small'">Adventures.AdventurePoints</span></span>
</div>
<div ng-if="type == 11">
	<span class="rewardIcon">
	<img class="buildingLarge buildingType{{value.buildingType}} tribeId{{tribeId}}"
		 tooltip tooltip-translate="Building_{{value.buildingType}}"/>
	</img></span>
	<span translate class="rewardText" data="rewardedLevel: {{value.rewardedLevel}}">Quest.Reward.BuildingLevel</span>
</div>
<div ng-if="type == 12">
	<span class="rewardIcon"><i class="premium_plusAccount_large_illu"></i></span>
	<span class="rewardText"><span translate data="amount: {{value}}">Quest.Reward_PlusAccount</span></span>
</div>
<div ng-if="type == 13">
	<span class="rewardIcon"><i class="premium_productionBonus_large_illu"></i></span>
	<span class="rewardText"><span translate data="amount: {{value}}">Quest.Reward_ResourceBonus</span></span>
</div>
<div ng-if="type == 14">
	<span class="rewardIcon"><i class="premium_cropProductionBonus_large_illu"></i></span>
	<span class="rewardText"><span translate data="amount: {{value}}">Quest.Reward_CropBonus</span></span>
</div>
</script>
<script type="text/ng-template" id="tpl/directive/generalElements/serverautocomplete.html"><span class="serverautocompleteContainer">

	<ul ng-if="showOwnVillages" class="ownVillageList"
		ng-class="{visible: ownVillagesListVisible}">
		<li ng-repeat="village in ownVillages">
			<a clickable="selectOwnVillage($index)"><div class="resultRow"><span class="resultName">{{village.name}}</span><span class="resultType"><div coordinates nolink="true" x="{{village.coordinates.x}}" y="{{village.coordinates.y}}"></div></span></div></a>
		</li>
	</ul>
	<input ng-disabled="disabledInput" class="targetInput" type="text" ng-model="modelInput" ng-focus="onFocus();hideOwnVillagesList();">
	<label ng-class="{ownVillagesShown: showOwnVillages}">
		<i class="action_search_tiny_flat_white"></i>
		{{searchTypes}}
	</label>
	<a ng-if="showOwnVillages" class="villageQuickSelect iconButton"
	   clickable="toggleOwnVillagesList()"
	   ng-class="{active: ownVillagesListVisible}">
		<i class="villageList_villageOverview_small_flat_black"></i>
	</a>
</span></script>
<script type="text/ng-template" id="tpl/directive/generalElements/switch.html"><label class="clickInputLabel">
	<span class="switchLabel" ng-class="{selected: !switch}">{{switchName1}}</span>
	<div class="clickInputWrapper switchBox" ng-class="{switchedOn: switch}">
		<div class="switchButtonWrapper">
			<input type="checkbox" class="switch" ng-disabled="switchDisabled" ng-model="switch" ng-change="switchChanged()">
			<i ng-class="{action_check_tiny_flat_black: switch, action_cancel_tiny_flat_black: !switch}"></i>
		</div>
	</div>
	<span class="switchLabel" ng-class="{selected: switch}">{{switchName2}}</span>
</label></script>
<script type="text/ng-template" id="tpl/enterMail/enterMail.html"><div id="ingameRegistration" ng-controller="enterMailCtrl">

    <div class="full" ng-if="useMellon">
        <mellon-frame url="{{registerIframe}}" additional-class="registerIngame"></mellon-frame>
    </div>
    <div ng-if="!useMellon">

        <div class="control-group">
            <label class="control-label" for="registerInputUsername" translate>Username</label>

            <div class="controls">
                <input type="text" maxlength="15" id="registerInputUsername" placeholder="Username"
                       ng-model="input.name"  />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="registerInputUsername" translate>Email</label>

            <div class="controls">
                <input type="text" id="registerInputEmail" placeholder="Email"
                       ng-model="input.email" ng-change="checkInput()" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="registerInputPassword" translate>Password</label>

            <div class="controls">
                <input type="password" id="registerInputPassword"
                       placeholder="Password" ng-model="input.password" ng-change="checkInput()" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="inputPasswordCheck" translate>RepeatPassword</label>

            <div class="controls">
                <input type="password" id="inputPasswordCheck"
                       placeholder="Password" ng-model="input.passwordCheck" ng-change="checkInput()" />
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <button type="submit" clickable="save()" ng-class="{disabled: !valid}">
               		<span translate>Register</span>
				</button>
            </div>
        </div>
    </div>
</div></script>
<script type="text/ng-template" id="tpl/farmListAdd/farmListAdd.html"><div class="farmListAdd" ng-controller="farmListAddCtrl">
	<div class="farmListWrapper" scrollable>
		<div class="farmListInner" on-pointer-over="removePreselected()">
			<h6 ng-if="action === FarmListEntry.ACTION.TOGGLE">
				<span translate>FarmList.AddToList.Toggle</span>
			</h6>
			<h6 ng-if="action !== FarmListEntry.ACTION.TOGGLE">
				<span translate data="targetId: {{villageId}}, targetName: {{village.data.name}}">FarmList.AddToList</span>
			</h6>
			<div class="list" ng-repeat="(key, farmlist) in farmListCollection"
				 clickable="addVillage({{farmlist.data.listId}})"
				 ng-if="farmlist.data.isDefault || player.hasPlusAccount()"
				 ng-class="{'preselected': key === 0 && preselected}">
				<i class="action_check_small_flat_green" ng-if="villageInFarmLists.indexOf(farmlist.data.listId) > -1"></i>
				<i class="action_check_small_flat_black" ng-if="villageInFarmLists.indexOf(farmlist.data.listId) === -1"></i>
				{{farmlist.data.listName}}
				<span>
					<i class="village_village_small_flat_black" tooltip tooltip-translate="FarmList.Tooltip.villages" ng-click="$event.stopPropagation()"></i>
					{{0 | bidiRatio:farmListEntriesCount[farmlist.data.listId]:farmlist.data.maxEntriesCount}}
				</span>
			</div>
			<div ng-if="error" class="error" translate options="{{error}}" data="param:{{errorParam}}">?</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/gameTimeline/gameTimeline.html"><div ng-controller="gameTimelineCtrl" ng-init="gameSteps = ['gameStart', 'secondVillage', 'city', 'catapults', 'treasures', 'natars', 'gameEnd']">
	<div class="stepCarousel">
		<div ng-repeat="step in ::gameSteps" ng-init="selection.step = 0"
			 class="stepContainer" clickable="selection.step = $index"
			 ng-class="{selected: selection.step == $index, stepHover: selection.hover == $index,
			 			beforeSelected: selection.step > $index, afterSelected: selection.step < $index}"
			 on-pointer-over="selection.hover = $index" on-pointer-out="selection.hover = -1">
			<div class="stepFrame">
				<div class="stepIllustration timeline_{{::step}}_illustration"></div>
				<div class="contentBox gradient">
					<h6 class="contentBoxHeader headerWithArrowEndings">
						<div class="content" translate options="{{::$index}}">GameTimeline.StepHeader_?</div>
					</h6>
					<div class="contentBoxBody" translate options="{{::$index}}">GameTimeline.StepDescription_?</div>
				</div>
			</div>
		</div>
	</div>
	<table class="stepTimeline transparent">
		<tr>
			<td ng-repeat="step in ::gameSteps"
				tooltip tooltip-translate="GameTimeline.StepHeader_{{$index}}" tooltip-class="tooltipStyleBold" tooltip-placement="above"
				on-pointer-over="selection.hover = $index; selection.step = $index;" on-pointer-out="selection.hover = -1">
				<div class="stepButtonContainer" ng-class="{selected: selection.step == $index, stepHover: selection.hover == $index}">
					<div class="stepButton"></div>
				</div>
				<i ng-if="::$first" class="feature_beginnersProtection_medium_illu"
				   tooltip tooltip-translate="KingOrGovernor.BeginnerProtection" tooltip-class="tooltipStyleBold" tooltip-placement="above"></i>
			</td>
		</tr>
		<tr>
			<td ng-repeat="step in ::gameSteps">
				<span ng-if="::$first" translate>Today</span>
				<span ng-if="::$index == 1">1.<span translate>Week</span></span>
				<span ng-if="::$index > 1">{{$index}}.<span translate>Month</span></span>
			</td>
		</tr>
	</table>
</div>
</script>
<script type="text/ng-template" id="tpl/help/help.html"><div ng-controller="helpMenuCtrl" class="helpMenu">
	<div class="navigation contentBox gradient">
		<div class="navigationWrapper" ng-class="{'level1': navigationLevel == 1, 'level0': navigationLevel == 0}">
			<div class="topLevelNav">
				<h6 class="headerWithIcon arrowDirectionTo">
					<i class="symbol_questionMark_small_flat_black"></i>
					<span translate>HelpMenu.QuickGuide</span>
				</h6>
				<div class="navContent" scrollable>
					<div class="entries">
						<div ng-repeat="(id,child) in topLevelNav | sortObjectsByNumericProperty:'order'">
							<div class="clickableContainer" ng-if="child.type == 'topic'" clickable="openHelp(child.key, child.type);">
								<span translate options="{{child.key}}">InGameHelp.?.Headline</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="subLevelNav">
				<div class="header subLevelHeader">
					<div class="clickableContainer" clickable="goBackToTopLevelNav()">
						<i class="symbol_arrowFrom_small_flat_black"></i>
					</div>
					<span translate ng-if="pageId != 'index'" options="{{pageId}}">InGameHelp.?.Headline</span>
				</div>
				<div class="navContent" scrollable>
					<div class="entries">
						<div ng-repeat="(id,child) in subLevelNav | sortObjectsByNumericProperty:'order'">
							<div ng-if="child.type == 'view'" class="entry">
								<div class="entryButton truncated"
									 clickable="openHelp(child.key, child.type);"
									 ng-class="{'active': viewId == child.key}"
									 translate options="{{child.key}}">InGameHelp.?.Headline</div>
							</div>
							<div ng-if="child.type == 'group'" class="header groupHeader">
								<span translate options="{{child.key}}">InGameHelp.?.Headline</span>
							</div>
							<div ng-if="child.type == 'group'" ng-repeat="(childId,childChild) in child.children | sortObjectsByNumericProperty:'order'">
								<div ng-if="childChild.type == 'building'" class="entry truncated">
									<div class="entryButton"
										 clickable="openHelp(childChild.key, childChild.type);"
										 ng-class="{'active': viewId == childChild.key}"
										 translate options="{{childChild.data.buildingType}}">Building_?</div>
								</div>
								<div ng-if="childChild.type == 'unit'" class="entry truncated">
									<div class="entryButton"
										 clickable="openHelp(childChild.key, childChild.type);"
										 ng-class="{'active': viewId == childChild.key}"
										 translate options="{{childChild.data.id}}">Troop_?</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="contentBox helpContent gradient">
		<div class="contentBoxHeader headerWithArrowDown" ng-if="viewId == 'index'">
			<span translate>InGameHelp.RandomTopic</span>:
			<span translate options="{{randomTopic.viewId}}" class="pageTitle">InGameHelp.?.Headline</span>
		</div>
		<h6 class="contentBoxHeader headerWithArrowEndings viewContentText" ng-if="page.type == 'unit'">
			<div class="content">
				<span translate options="{{page.data.id}}">Troop_?</span>
				<span class="tribe">(<span translate options="{{page.data.tribe}}">Tribe_?</span>)</span>
			</div>
		</h6>
		<h6 class="contentBoxHeader headerWithArrowEndings" ng-if="page.type == 'building'">
			<div class="content">
				<span translate options="{{page.data.buildingType}}">Building_?</span>
				<span ng-if="page.data.tribeId > 0 && page.data.tribeId <= 3" class="tribe">(<span translate options="{{page.data.tribeId}}">Manual.OnlyTribe_?</span>)</span>
			</div>
		</h6>
		<div class="contentBoxBody"
			 ng-class="{
			 'indexContentBody': viewId == 'index',
			 'unitOrBuilding': page.type == 'building' || page.type == 'unit',
			 'viewContentBody': viewId != 'index'}">
			<div ng-if="viewId == 'index'" class="indexView">
				<div class="topicImage help_image_{{randomTopic.viewId}}_{{currentStep}} help_image_{{randomTopic.viewId}}_{{currentStep}}_{{tribe}}">

				</div>
				<div class="truncated indexContent">
					<div class="contentBox transparent">
						<div class="contentBoxHeader headerWithArrowEndings">
							<div class="content">
								<span translate options="{{randomTopic.viewId}}">InGameHelp.?.Headline</span>
							</div>
						</div>
						<div class="contentBoxBody">
							<span translate options="{{randomTopic.viewId}}, {{currentStep}}" limit="300">InGameHelp.?.Step?</span>
							<a clickable="openView(randomTopic.viewId, randomTopic.type);"><span translate>InGameHelp.ReadMore</span></a>
						</div>
					</div>
				</div>
				<div class="contentBox externalHelp">
					<div class="contentBoxHeader headerTrapezoidal">
						<div class="content">
							<span translate>HelpMenu.ExternalHelp</span>
						</div>
					</div>
					<div class="contentBoxBody">
						<a class="clickableContainer" clickable="openForum();"
						   ng-if="config['SERVER_ENV'] == 'live' && !isSitter">
							<span translate>HelpMenu.Forum</span>
						</a>
						<a class="clickableContainer" clickable="openHelpCenter();" ng-class="{disabled: isSitter}"
						   tooltip tooltip-translate="Sitter.Tooltip.Disabled" tooltip-show="{{isSitter}}">
							<span translate>HelpMenu.HelpCenter</span>
						</a>
						<a class="clickableContainer" clickable="openWiki();" ng-if="showWiki">
							<span translate>HelpMenu.Wiki</span>
						</a>
					</div>
				</div>
				<div class="legalLinks">
					<a clickable="openOverlay('gameRulesOverlay')" translate>HelpMenu.GameRules</a> |
					<a clickable="openOverlay('termsAndConditionsOverlay')" translate>HelpMenu.AGB</a> |
					<a clickable="openOverlay('privacyOverlay')" translate>HelpMenu.Privacy</a> |
					<a clickable="openOverlay('imprintOverlay')" translate>HelpMenu.Imprint</a>
				</div>
			</div>
			<div ng-if="subLevelNav[viewId].type == 'view'" class="contentBox viewContent">
				<div class="topicImage help_image_{{viewId}}_{{currentStep}} help_image_{{viewId}}_{{currentStep}}_{{tribe}}">

				</div>
				<div class="contentBox transparent">
					<div class="contentBoxHeader headerWithArrowEndings viewContentText">
						<div class="content">
							<span translate options="{{viewId}}">InGameHelp.?.Headline</span>
						</div>
					</div>
					<div class="contentBoxBody">
						<span translate options="{{viewId}}, {{currentStep}}">InGameHelp.?.Step?</span>
						<div class="wikiLink" ng-if="hasWikiUrl">
							<a translate clickable="openWikiUrl();">InGameHelp.WikiLink</a>
						</div>
					</div>
				</div>
				<div class="stepsContainer" ng-if="maxSteps > 1">
					<div class="arrowFrom unselectable" clickable="prevStep();" ng-mouseenter="hoverFromArrow = true" ng-mouseleave="hoverFromArrow = false">
						<i class="symbol_arrowFrom_small_flat_black" ng-class="{'symbol_arrowFrom_small_flat_green': hoverFromArrow}"></i>
					</div>
					<div class="stepButtonsContainer">
						<a class="stepButton" ng-repeat="step in [] | range:1:maxSteps" clickable="changeStep(step)" ng-class="{'last':$last, 'active': currentStep == step}">
							{{step}}
						</a>
					</div>
					<div class="arrowTo unselectable" clickable="nextStep();" ng-mouseenter="hoverToArrow = true" ng-mouseleave="hoverToArrow = false">
						<i class="symbol_arrowTo_small_flat_black" ng-class="{' symbol_arrowTo_small_flat_green': hoverToArrow}"></i>
					</div>
				</div>
			</div>
			<div ng-if="page.type == 'building' && buildingData">
				<div class="manual buildings">
					<div class="details" ng-include="'tpl/manual/partials/buildingsDetails.html'"></div>
				</div>
			</div>

			<div ng-if="page.type == 'unit' && troopData">
				<div class="manual troops">
					<div class="details" ng-include="'tpl/manual/partials/unitsDetails.html'"></div>
				</div>
			</div>
		</div>
	</div></script>
<script type="text/ng-template" id="tpl/help/helpExternalContentOverlay.html"><iframe ng-src="{{link}}" width="752" height="450" frameBorder="0"></iframe></script>
<script type="text/ng-template" id="tpl/hero/hero.html"><div id="hero" ng-controller="heroCtrl">
    <div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/hero/overlay/confirmSelling.html"><div ng-if="isNpcBuying === false" translate>Auction.DirectAuctionExplanation
</div>
<div ng-if="isNpcBuying">
	<div ng-if="tier > 0 && owners == 0" translate options="{{strengthFactor}}">Auction.QualityAndOwnersNew_?</div>
	<div ng-if="tier > 0 && owners > 0" translate data="owners:{{owners}}" options="{{strengthFactor}}">Auction.QualityAndOwners_?</div>
	<div ng-if="tier == 0 && owners == 0" translate>Auction.QualityAndOwnersStackableNew</div>
	<div ng-if="tier == 0 && owners > 0" translate data="owners:{{owners}}">Auction.QualityAndOwnersStackable</div>
	<br>
	<div translate data="price:{{price}}" ng-if="!isStackable">
		Auction.SellSingleItemToNpc
	</div>
	<div translate data="amount:{{amount}},price:{{price}},totalPrice:{{price * amount}}" ng-if="isStackable">
		Auction.SellStackedItemToNpc
	</div>
</div>
<div ng-if="equipped" class="error" translate>Auction.SellEquipped</div>
<div class="buttonFooter">
	<button clickable="sellItemAction()" play-on-click="{{UISound.BUTTON_SELL_ITEM}}">
		<span translate>Button.Ok</span>
	</button>
	<button class="cancel" clickable="closeOverlay()">
		<span translate>Button.Cancel</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/hero/overlay/sellStolenGoods.html"><div class="sellStolenGoods">
	<div class="itemContainer">
		<span translate>Hero.SellTreasures.Description</span>
	</div>

	<div class="contentBoxRow">
		<div class="contentBox player">
			<div class="contentBoxBody">
				<avatar-image class="playerAvatar" scale="1" player-id="{{currentPlayer.data.playerId}}"></avatar-image>
			</div>
			<div class="contentBoxFooter">
				<span player-link playerId="{{currentPlayer.data.playerId}}" playerName="{{currentPlayer.data.name}}"></span>
			</div>
		</div>
		<div class="contentBox treasure">
			<div class="contentBoxBody">
				<i class="treasureImage unit_stolenGoods_huge_illu"></i>
			</div>
			<div class="contentBoxFooter gradient double">
				<span ng-if="!soldResources" class="usingTreasures">{{0 | bidiRatio:useAmount.value:maxAmount}}</span>
				<span ng-if="soldResources" class="usingTreasures">{{soldAmount}}</span>
			</div>
		</div>
		<div class="contentArrow"></div>
		<div class="contentBox king">
			<div class="contentBoxBody">
				<avatar-image class="kingAvatar" scale="1" player-id="{{king.playerId > 100 ? king.playerId : robber}}"></avatar-image>
			</div>
			<div class="contentBoxFooter">
				<i class="community_king_small_flat_black"></i>
				<span player-link playerId="{{king.playerId}}" playerName="" ng-if="king.playerId > 100"></span>
				<a class="playerLink  truncated disabled" ng-if="king.playerId < 100"  translate>BanditChief</a>
			</div>
		</div>
	</div>
	<div class="arrow"></div>
	<div class="contentBox treasuresChoice">
		<div ng-if="!soldResources" class="contentBoxHeader headerColored">
			<slider class="treasureSlider"
					slider-min="1"
					slider-max="maxAmount"
					slider-data="useAmount"
					input-autofocus="true"></slider>
		</div>
		<div ng-if="soldResources" class="resourceOnWayHeader contentBoxHeader headerColored">
			<span translate>Hero.SellTreasures.DeliveryIsOnWay</span>
		</div>
		<div class="contentBoxHeader headerTrapezoidal">
			<div class="content">
				<span class="treasureDuration">
					<i class="symbol_clock_small_flat_black"></i>
					<span translate ng-if="!soldResources" data="duration:{{treasureDuration}}">Hero.SellTreasures.DeliveryDuration</span>
					<span translate ng-if="soldResources" class="countdownTo" data="finishTime:{{inboundTroopArriveTime}}">Hero.SellTreasures.DeliveryCountdown</span>
				</span>
			</div>
		</div>
		<div class="contentBoxBody">
			<div class="floatWrapper costs">
				<div class="resourceBig" ng-repeat="resource in ['wood', 'clay', 'iron']">
					<div class="resourceWrapper">
						<p><i class="unit_{{resource}}_large_illu"></i></p>

						<p ng-if="!soldResources" class="resourceDescription"
						   ng-class="{colorPositive: fittingInStorage($index+1) && treasurePrice[$index+1] > 0, colorNegative: (!fittingInStorage($index+1) || treasurePrice[$index+1] < 0)}">
							<span class="resource">{{treasurePrice[$index+1] | bidiNumber:numberUnit:true:false}}</span>
						</p>
						<p ng-if="soldResources" class="resourceDescription">
							<span class="resource">{{soldResources[$index+1] | bidiNumber:numberUnit:false:false}}</span>
						</p>
					</div>
				</div>

				<div class="cropTooltipArea" tooltip tooltip-translate="Hero.SellTreasures.CropTooltip" tooltip-show="true" tooltip-class="treasureCrop" tooltip-placement="above" tooltip-child-class="symbol_i_tiny_wrapper">
					<div class="symbol_i_tiny_wrapper">
						<i class="symbol_i_tiny_flat_white"></i>
					</div>
				</div>
				<div class="resourceBig">
					<div class="resourceWrapper">
						<div class="cropWarning" ng-if="king.stranger || king.playerId < 100">
							<span translate>Hero.SellTreasures.CropWarning</span>
						</div>
						<div class="cropToTreasure">
							<i class="treasureIcon unit_treasure_medium_illu"></i>
							<i class="unit_crop_large_illu"></i>
						</div>
						<p ng-if="!soldResources" class="resourceDescription"
						   ng-class="{colorPositive: fittingInStorage(4) && treasurePrice[4] > 0, colorNegative: (!fittingInStorage(4) || treasurePrice[4] < 0)}">
							<span class="resource">{{treasurePrice[4] | bidiNumber:numberUnit:true:false}}</span>
						</p>
						<p ng-if="soldResources" class="resourceDescription">
							<span class="resource">{{soldResources[4] | bidiNumber:numberUnit:false:false}}</span>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="buttonBar">
		<span>
			<button ng-if="treasurePrice && !inboundTroopId" class="useItemButton" clickable="sellTreasures()" play-on-click="{{UISound.BUTTON_SELL_STOLEN_GOODS}}">
				<span translate>Hero.SellTreasures</span>
			</button>
			<button ng-if="inboundTroopId"
					class="premium instantDelivery"
					premium-feature="treasureResourcesInstant"
					premium-callback-param="{{inboundTroopId}}"
					price="{{premiumFeaturePrice}}">
				<span translate>RallyPoint.Overview.InstantDelivery</span>
			</button>
			<button clickable="closeOverlay()" class="cancel">
				<span translate>Button.Cancel</span>
			</button>
		</span>

	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/hero/overlay/unlockAdditionalLocation.html"><div class="unlockAdditionalLocation useItem">
	<div class="contentBox">
		<h6 class="contentBoxHeader headerWithArrowDown" translate>Hero.BuildingGround.Header</h6>
		<div class="contentBoxBody">
			<div class="itemContainer">
				<img class="heroItem_building_ground_large_illu">
				<div class="verticalLine"></div>
				<span ng-if="unlockedGrounds < maxPremiumLocations" class="confirmation description" translate>Hero.BuildingGround.Confirmation</span>
				<span ng-if="unlockedGrounds == maxPremiumLocations" class="confirmation description" translate>Hero.BuildingGround.Limit</span>
			</div>
			<div class="horizontalLine"></div>
			<table class="buildingGrounds transparent">
				<tr>
					<th colspan="2">
						<span ng-bind-html="0 | bidiRatio:unlockedGrounds:maxPremiumLocations"></span>
						<span ng-if="unlockedGrounds == maxPremiumLocations" translate>Hero.BuildingGround.Maximum</span>
					</th>
				</tr>
				<tr>
					<td><i class="premiumLocationPreview first" ng-class="{disabled: unlockedGrounds == 0}"></i></td>
					<td><i class="premiumLocationPreview second" ng-class="{disabled: unlockedGrounds < 2}"></i></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="buttonBar">
		<button clickable="unlockGround()" class="useItemButton" ng-class="{disabled: unlockedGrounds == maxPremiumLocations}">
			<span translate>Hero.BuildingGround.Button.Unlock</span>
		</button>
		<button clickable="closeOverlay()" class="cancel">
			<span translate>Button.Cancel</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/overlay/upgradeBandages.html"><div class="useItem upgradeBandages">
	<div class="contentBox healingPotionBoxTop">
		<h6 class="contentBoxHeader headerWithArrowDown">
            <div class="content" translate ng-if="isSmallBandage">Hero.ItemUpgradeBandagesSmallHeadline</div>
            <div class="content" translate ng-if="!isSmallBandage">Hero.ItemUpgradeBandagesHeadline</div>
		</h6>
		<div class="contentBoxBody">
			<div class="itemContainer">
				<hero-item-container item="healingPotions" hide-amount="true" hide-item-states="true"></hero-item-container>
				<div class="verticalLine"></div>
                <div class="description bandageUpgradeText" translate ng-if="isSmallBandage">Hero.ItemUpgradeSmallBandagesUsage</div>
                <div class="description bandageUpgradeText" translate ng-if="!isSmallBandage">Hero.ItemUpgradeBandagesUsage</div>
			</div>

			<div class="horizontalLine"></div>

			<div class="calculationContainer">
				<div class="itemWrapper">
					<hero-item-container item="bandages" hide-item-states="true" hide-amount="true"></hero-item-container>
					<span class="itemAmount" ng-bind-html="0 | bidiRatio : useAmount.value : bandages.data.amount"></span>
				</div>

				<div class="plusCircled"></div>

				<div class="itemWrapper">
					<hero-item-container item="healingPotions" hide-amount="true" hide-item-states="true"></hero-item-container>
					<span class="itemAmount" ng-bind-html="0 | bidiRatio : useAmount.value : healingPotions.data.amount"></span>
				</div>

				<div class="equalCircled"></div>

				<div class="itemWrapper">
					<hero-item-container class="resultItem result" item="bandages" hide-amount="true" hide-item-states="true" display-next-upgrade="true"></hero-item-container>
					<span class="itemAmount">{{useAmount.value}}</span>
				</div>
			</div>
		</div>

		<div class="contentBoxFooter">
			<div class="sliderArrow"></div>
			<slider slider-min="1" slider-max="maxUseableAmount" slider-data="useAmount"></slider>
		</div>
	</div>

	<div class="buttonBar">
		<button clickable="upgradeBandage()" class="useItemButton"
                tooltip
                tooltip-translate-switch="{
		            'Hero.ItemUpgradeBandagesButtonTooltip': {{!isSmallBandage}},
		            'Hero.ItemUpgradeSmallBandagesButtonTooltip': {{isSmallBandage}}
                    }">
			<span translate data="ItemName:{{itemName}}">Hero.MergeItem</span>
		</button>
		<button clickable="cancel()" class="cancel">
			<span translate>Button.Cancel</span>
		</button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/hero/overlay/upgradeItem.html"><div class="useItem upgradeItem">
	<div class="contentBox">
		<div class="contentBoxHeader headerWithArrowDown" translate options="{{item.data.itemType}}">
			Hero.Item.Upgrade_?
		</div>
		<div class="contentBoxBody">
			<div class="itemContainer">
				<hero-item-container item="item" hide-amount="true" hide-item-states="true"></hero-item-container>
				<div class="verticalLine"></div>
				<div class="description" translate data="maxUpgrade: {{maxPossibleUpgrades}}" options="{{item.data.itemType}}">Hero.Item.UpgradeText_?</div>
			</div>
			<div class="horizontalLine"></div>

			<div class="selectItemContainer">
				<div class="selectUpgrade" translate>
					Hero.Item.UpgradeSelect
				</div>
				<div dropdown data="itemDropdown">{{option.text}}</div>
			</div>
			<div class="horizontalLine"></div>
			<div class="calculationContainer">
				<div class="itemWrapper">
					<hero-item-container item="targetItem" hide-item-states="true" ng-class="{empty: !targetItem.data}" tooltip-condition="targetItem.data"></hero-item-container>
				</div>
				<div class="plusCircled"></div>
				<div class="itemWrapper">
					<hero-item-container item="item" hide-amount="true" hide-item-states="true"></hero-item-container>
				</div>
				<div class="equalCircled"></div>
				<div class="itemWrapper">
					<hero-item-container item="targetItem" ng-class="{empty: !targetItem.data, result: targetItem.data }" hide-item-states="true"
										 tooltip-condition="targetItem.data" display-next-upgrade="true"></hero-item-container>
				</div>
			</div>
			<div class="horizontalLine"></div>
			<div class="upgradeMessage">
				<span translate ng-if="effect.type > 0" options="{{effect.type}}" data="x:{{effect.strength}}">Hero.ItemUpgradeBonus_?</span><br>
			</div>
		</div>
	</div>
	<div class="buttonBar">
		<button clickable="upgradeItem()" class="upgradeItemButton" ng-class="{disabled: !targetItem.data}">
			<span translate>Hero.UpgradeItem</span>
		</button>
		<span>
			<button clickable="closeOverlay()" class="cancel">
				<span translate>Button.Cancel</span>
			</button>
		</span>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/hero/overlay/useItem.html"><div class="useItem">

	<div ng-if="isHealingPotion">
		<div class="contentBox healingPotionBoxTop">
			<h6 class="contentBoxHeader headerWithArrowDown">
				<div class="content" translate>Hero.ItemUsePotionsHeadlineUpgrade</div>
			</h6>
			<div class="contentBoxBody">
				<div class="upgradeText" translate>Hero.ItemUpgradeBandagesNote</div>
				<a class="clickableContainer bandageButton"
				   clickable="showUpgradeBandageDialog(smallBandagesId)"
				   tooltip
				   tooltip-translate="Hero.TooltipUpgradeSmallBandages"
				   ng-class="{disabled: smallBandagesAmount <= 0}">
					<span class="headline" translate options="{{HeroItem.TYPE_BANDAGE_25}}">Hero.Item_?</span>
					<span class="horizontalLine double"></span>
					<img class="heroItem_small_bandage_large_illu" src="layout/images/x.gif">
				</a>
				<div class="verticalLine"></div>
				<a class="clickableContainer bandageButton"
				   clickable="showUpgradeBandageDialog(largeBandagesId)"
				   tooltip
				   tooltip-translate="Hero.TooltipUpgradeLargeBandages"
				   ng-class="{disabled: largeBandagesAmount <= 0}">
					<span class="headline" translate options="{{HeroItem.TYPE_BANDAGE_33}}">Hero.Item_?</span>
					<span class="horizontalLine double"></span>
					<img class="heroItem_bandage_large_illu" src="layout/images/x.gif">
				</a>
				<div class="clear"></div>
			</div>
		</div>

		<div class="contentBox">
			<h6 class="contentBoxHeader headerWithArrowDown">
				<div class="content" translate>Hero.ItemUsePotionsHeadlineUse</div>
			</h6>
			<div class="contentBoxBody">
				<div class="itemContainer">
					<hero-item-container item="item" hide-amount="true" hide-item-states="true" ></hero-item-container>
					<div class="verticalLine"></div>
					<div class="confirmation bandageUpgradeText" translate>Hero.ItemUsePotionsBodyUse</div>
				</div>
			</div>
		</div>
	</div>

	<div ng-if="!isHealingPotion" class="itemContainer">
		<hero-item-container item="item" hide-amount="true" hide-item-states="true" ></hero-item-container>
		<div class="verticalLine"></div>
		<div ng-if="isArtwork" class="confirmation description"><p><span translate data="amount:{{cultureProduction}}">Hero.Item.UseConfirmation.ArtworkAmount</span></p></div>
		<div ng-if="!stackable" class="confirmation description" translate>Hero.Item.UseConfirmation</div>
		<div ng-if="stackable" class="confirmation description" translate>Hero.Item.HowManyUse</div>
	</div>

	<div ng-if="stackable">
		<div class="horizontalLine"></div>
		<div class="treasure" ng-if="treasurePrice">
			<span translate>Hero.SellTreasuresQuestion</span>
			<display-resources ng-if="!treasuresSold" resources="treasurePrice" check-storage="true"></display-resources>
			<display-resources ng-if="treasuresSold" resources="treasuresSold"></display-resources>
			<span ng-if="!treasuresSold" class="treasureDuration"><i class="unit_speed_small_flat_black"></i> {{treasureDuration|HHMMSS}}</span>
			<span ng-if="treasuresSold" class="treasureDuration"><i class="unit_speed_small_flat_black"></i> <span countdown="{{treasureDelivery.destTime}}"></span></span>
		</div>
		<slider ng-if="stackable && !treasuresSold"
				class="confirmation"
				slider-min="1"
				slider-max="maxAmount"
				slider-data="useAmount"
				input-autofocus="true"></slider>
		<div class="treasureOnItsWay" translate ng-if="treasuresSold">Hero.DeliveryIsOnItsWay</div>
	</div>

	<div class="buttonBar">
		<span ng-if="!treasuresSold">
			<button ng-if="!treasurePrice" clickable="useItem()" class="useItemButton">
				<span translate data="ItemName:{{itemName}}">Hero.UseItem</span>
			</button>

			<button ng-if="treasurePrice" class="useItemButton" clickable="sellTreasures()" play-on-click="{{UISound.BUTTON_SELL_STOLEN_GOODS}}">
				<span translate>Hero.SellTreasures</span>
			</button>
			<button clickable="closeOverlay()" class="cancel">
				<span translate>Button.Cancel</span>
			</button>
		</span>
		<span ng-if="treasuresSold">
			<button class="premium"
					premium-feature="treasureResourcesInstant"
					premium-callback-param="{{treasureDelivery.troopId}}"
					price="{{treasureDelivery.price}}">
				<span translate>Tribute.FetchInstant</span>
			</button>
		</span>
	</div>

</div>
</script>
<script type="text/ng-template" id="tpl/hero/overlay/useResourceBonus.html"><div class="useItem useResourceItem">
	<div class="contentBox useItem" ng-if="screenState == 'UseItem' || bonusValue >= 5 || item.data.amount <= 1">
		<div class="contentBoxHeader headerWithArrowDown">
				<span translate>Hero.UseResourceBonus.UseItem.Headline</span>
		</div>
		<div class="contentBoxBody">
			<div class="itemContainer">
				<hero-item-container item="item" hide-amount="true" hide-item-states="true"></hero-item-container>
				<div class="verticalLine"></div>
				<div translate class="description" data="amount:{{bonusValue}}, currentVillageName:{{village.data.name}}">Hero.UseResourceBonus.UseItem.Description</div>
			</div>


			<div class="horizontalLine"></div>
			<h6 class="headerTrapezoidal">
				<span translate class="content">Hero.UseResourceBonus.UseItem.smallHeadline</span>
			</h6>
			<div class="rewardContainer">
				<div class="selectedItemContainer">
					<hero-item-container
						class="selectedItem"
						hide-amount="true"
						hide-item-states="true"
						item="item"
						>
					</hero-item-container>
					<i class="arrowDown" ng-if="bonusValue < 5 && item.data.amount > 1"></i>
				</div>
				<i class="equalCircled"></i>
				<display-resources resources="resources" hide-zero="true" signed="true" image-size="large" check-storage="true"></display-resources>
			</div>
			<div class="horizontalLine"></div>
			<div class="buttonWrapper">
				<button clickable="changeScreenStateToMerge()" class="changeViewButton" ng-if="bonusValue < 5 && item.data.amount > 1">
					<span translate data="amount:{{bonusValue + 1}}">Hero.UseResourceBonus.UseItem.Button.MergeItem</span>
				</button>
				<span class="separator" ng-if="bonusValue < 5 && item.data.amount > 1"><span translate class="text">or</span> <i class="arrowDirectionTo"></i></span>
				<button class="useItemButton" clickable="useItem()" ng-class="{disabled: item.data.usedPerDay >= item.data.maxPerDayWithoutLock}" tooltip tooltip-translate="Hero.UseResourceBonus.UseItem.Button.UseBonus.Tooltip" tooltip-data="time: {{timeForNextUse}}" tooltip-hide="{{item.data.usedPerDay < item.data.maxPerDayWithoutLock}}">
					<span translate>Hero.UseResourceBonus.UseItem.Button.UseBonus</span>
				</button>
			</div>
		</div>
	</div>

	<div class="contentBox mergeItem" ng-if="screenState == 'MergeItem' && bonusValue < 5 && item.data.amount > 1">
		<div class="contentBoxHeader headerWithArrowDown">
			<span translate>Hero.UseResourceBonus.MergeItem.Headline</span>
		</div>
		<div class="contentBoxBody">
			<div class="itemContainer">
				<hero-item-container item="item" hide-amount="true" hide-item-states="true"></hero-item-container>
				<div class="verticalLine"></div>
				<div class="description" translate data="amount:{{bonusValue}}, newAmount:{{bonusValue + 1}}">Hero.UseResourceBonus.MergeItem.Description</div>
			</div>
			<div class="horizontalLine"></div>
			<div class="calculationContainer">
				<div class="itemWrapper">
					<hero-item-container item="item" hide-amount="true" hide-item-states="true"></hero-item-container>
					<span class="resourceValue" ng-bind-html="(useAmount.value / 2) | bidiRatio : (useAmount.value / 2) : item.data.amount"></span>
				</div>
				<i class="plusCircled"></i>
				<div class="itemWrapper">
					<hero-item-container item="item" hide-amount="true" hide-item-states="true"></hero-item-container>
					<span class="resourceValue" ng-bind-html="(useAmount.value / 2) | bidiRatio : (useAmount.value / 2) : item.data.amount"></span>
				</div>
				<i class="equalCircled"></i>
				<div class="itemWrapper">
					<hero-item-container item="item" hide-amount="true" hide-item-states="true" different-item-image="1" display-next-upgrade="true"></hero-item-container>
					<span class="resourceValue">{{useAmount.value / 2}}</span>
				</div>
			</div>
		</div>
		<div class="contentBoxFooter">
			<div class="sliderArrow"></div>
			<slider slider-min="2" slider-max="item.data.amount" slider-steps="2" hide-steps="true" slider-data="useAmount"></slider>
		</div>
	</div>
	<div class="buttonContainer">
		<button class="useItemButton" clickable="mergeItem()" ng-if="screenState == 'MergeItem'">
			<span translate>Hero.UseResourceBonus.MergeItem.Button.MergeBonus</span>
		</button>
		<button clickable="closeOverlay()" class="cancel">
			<span translate>Button.Cancel</span>
		</button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/hero/partials/attBonusPointsTooltip.html"><h3 translate>Hero.Attributes.attBonusPoints</h3>
<div class="horizontalLine"></div>
<span translate>Hero.Attributes.TooltipAttBonusPointsDescription</span>
<div class="horizontalLine" ng-if="disabled == 'true'"></div>
<span translate data="level: 10" ng-if="disabled == 'true'" class="warningLine">Hero.Attributes.Disabled</span>
<div class="horizontalLine"></div>
<span translate data="offBonus:{{val3}}">Hero.Attributes.TooltipAttBonusPointsValues</span></script>
<script type="text/ng-template" id="tpl/hero/partials/attributeInput.html"><input class="attributeInput" number="100" ng-model="total"/>

</script>
<script type="text/ng-template" id="tpl/hero/partials/cardgameFreePlayTooltip.html"><span translate data="cost: {{goldCost.cardgameSingle}}">CardGame.FreePlayIndicator.Tooltip</span>
<hr ng-show="cardgameRolls.data.freeRolls > 0 && !cardgameRolls.data.hasDailyRoll">
<span translate ng-show="cardgameRolls.data.freeRolls > 0 && !cardgameRolls.data.hasDailyRoll" data="nextFreePlay:{{midnight}}">CardGame.NextFreePlay</span></script>
<script type="text/ng-template" id="tpl/hero/partials/contentHeader.html"><div class="contentHeader">
    <h2>{{player.data.name}} - <span translate data="level: {{w.hero.level}}">Hero.Level</span></h2>
</div></script>
<script type="text/ng-template" id="tpl/hero/partials/defBonusPointsTooltip.html"><h3 translate>Hero.Attributes.defBonusPoints</h3>
<div class="horizontalLine"></div>
<span translate>Hero.Attributes.TooltipDefBonusPointsDescription</span>
<div class="horizontalLine" ng-if="disabled == 'true'"></div>
<span translate data="level: 10" ng-if="disabled == 'true'" class="warningLine">Hero.Attributes.Disabled</span>
<div class="horizontalLine"></div>
<span translate data="defBonus:{{val3}}">Hero.Attributes.TooltipDefBonusPointsValues</span></script>
<script type="text/ng-template" id="tpl/hero/partials/editor.html"><div class="heroEditor">
	<div class="contentBox gradient double previewBox">
		<h6 class="contentBoxHeader headerWithArrowEndings glorious">
			<div class="content" translate>Hero.Headline</div>
		</h6>
		<div class="contentBoxBody heroImageContainer" ng-class="{noGenderSelection: !config.balancing.features.femaleHero}">
			<avatar-image avatar="editorAvatar" size="big"></avatar-image>
		</div>
		<div class="contentBox gradient genderBox" ng-if="config.balancing.features.femaleHero">
			<div class="contentBoxBody">
				<div class="clickableContainer genderButton"
					 ng-class="{active: editorAvatar.gender == 'female'}"
					 clickable="changeGender(1)"
					 tooltip
					 tooltip-translate="Hero.Female">
					<i class="attribute_genderFemale_medium_flat_black"></i>
				</div>
				<div class="clickableContainer genderButton"
					 ng-class="{active: editorAvatar.gender == 'male'}"
					 clickable="changeGender(0)"
					 tooltip
					 tooltip-translate="Hero.Male">
					<i class="attribute_genderMale_medium_flat_black"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="contentBox gradient editHeroBox">
		<div class="contentBoxBody">
			<div class="editorElements">
				<table class="featureSelection transparent">
					<tbody>
						<tr>
							<td>
								<a clickable="previousOption()" class="iconButton doubleBorder previous">
									<i class="symbol_arrowFrom_tiny_flat_black"></i>
								</a>
							</td>
							<td>
								<div dropdown data="editorDropdown" class="doubleBorder"></div>
							</td>
							<td>
								<a clickable="nextOption()" class="iconButton doubleBorder next">
									<i class="symbol_arrowTo_tiny_flat_black"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="optionsTable transparent">
					<tbody>
						<tr ng-repeat="n in [] | range:0:2">
							<td ng-repeat="m in [] | range:0:3">
								<div class="option entityBox"
									 ng-class="{dummy: optionItems[(n*4)+m] == undefined,
								 active: (selectedOption != 'color' && heroFace.data.face[selectedOption] == (n*4)+m) ||
								 		 (selectedOption == 'color' &&  heroFace.data['hairColor'] == (n*4)+m)}">
									<div ng-if="optionItems[(n*4)+m] != undefined" class="clickContainer"
										 clickable="changeAttribute(selectedOption, (n*4)+m)">
										<hero-image-file
											ng-if="optionItems[(n*4)+m] != undefined"
											file="{{editorAvatar.gender+'/thumb/head/'+optionItems[(n*4)+m]}}"></hero-image-file>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="optionWrapper">
					<div class="dummyOptionContainer">

					</div>
				</div>
			</div>
			<button class="randomButton jsHeroEditorRandomButton" clickable="selectRandomFace()">
				<span translate>Hero.Random</span>
			</button>
		</div>
	</div>
	<div class="buttonBar">
		<button clickable="save()" class="saveButton jsHeroEditorSaveButton">
			<span translate>Hero.Attributes.SaveBtn</span>
		</button>
		<button ng-class="{disabled: !somethingChanged()}" clickable="resetChanges()" class="resetButton cancel">
			<span translate>Hero.ResetChanges</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/partials/fightStrengthPointsTooltip.html"><h3 translate>Hero.Attributes.fightStrengthPoints</h3>
<div class="horizontalLine"></div>
<span translate>Hero.Attributes.TooltipFightStrengthPointsDescription</span>
<div class="horizontalLine"></div>
<span translate data="hero:{{val1}}, equipment:{{val2|number:0}}">Hero.Attributes.TooltipFightStrengthPointsValues</span></script>
<script type="text/ng-template" id="tpl/hero/partials/healthTooltip.html"><h3 translate>Hero.Health</h3>
<div class="horizontalLine"></div>
<span translate data="heroRegen:{{hero.baseRegenerationRate}}">Hero.HealthTooltip.HeroRegen</span>
<div class="horizontalLine" ng-if="hero.itemsHealthRegen != 0"></div>
<span ng-if="hero.itemsHealthRegen != 0">
	<span translate data="itemsRegen:{{heroItemsHealthRegen}}">Hero.HealthTooltip.ItemsRegen</span>
</span></script>
<script type="text/ng-template" id="tpl/hero/partials/heroItemContainer.html"><div class="entityBox item draggableItem draggable item_{{itemObject.data.itemType}}"
	 ng-class="{ 	disabled: (itemObject.data.clickDisabled && !hideStates) || !itemObject.filled,
				 	equipped: itemObject.data.inSlot > 0 && !hideEquippedState,
				 	highlight: highlighted(),
				 	premiumItem: itemObject.data.premiumItem,
				 	empty: !itemObject.filled
				 }"

	 tooltip
	 tooltip-url="tpl/hero/partials/itemTooltip.html"
	 tooltip-data="id:{{itemObject.data.id}},notUsableItem:{{itemObject.data.notUsableItem && !hideStates}},notUsableReason:{{itemObject.data.notUsableReason}},auctionItem:false,nextUpgradeLevel:{{showNextUpgrade}}"
	 tooltip-show="{{showTooltip}}"

	 clickable="clickHandler(itemObject)"
	 on-pointer-over="onPointerOverHandler()"
	 on-pointer-out="highlightObject.turnOff(0)"

	 draggable="itemObject.filled ? getItem : null"
	 dropable="dragObject.dropable(object, itemObject)"
	 on-drag-stop="dragObject.dragStop(object)"
	 on-drag-init="dragObject.dragStart()"
	 disable-touch-drag="true"
	>

	<i class="dragMarker" ng-show="dragObject"></i>
	<img class="heroItem_{{itemObject.data.images[itemImageIndex]}}_large_illu {{avatar.gender}}" src="layout/images/x.gif">

	<div class="symbol_lock_small_wrapper" ng-if="itemObject.data.clickDisabled && !hideStates">
		<i class="lockedState symbol_lock_small_flat_black"></i>
	</div>
	<i class="itemState"
	   ng-if="!hideStates"
	   ng-class="{
				symbol_exclamationMark_small_flat_white: 	itemObject.data.inSlot == 0 && itemObject.data.lastChange > lastView && lastView > 0 && !viewedItems[itemObject.data.id],
				action_check_small_flat_white: 				itemObject.data.inSlot > 0 && !hideEquippedState,
				cardGame_prizeNormal_medium_illu:			itemObject.data.cardGameItem && itemObject.data.inSlot == 0 && !(itemObject.data.lastChange > lastView && lastView > 0 && !viewedItems[itemObject.data.id]),
				cardGame_prizePremium_medium_illu:			itemObject.data.premiumItem && itemObject.data.inSlot == 0 && !(itemObject.data.lastChange > lastView && lastView > 0 && !viewedItems[itemObject.data.id])
				}"></i>

	<div class="amountContainer upgradedItem" ng-show="itemObject.data.upgradedItem && !hideAmountContainer">
		<div class="amount">
			<i class="upgrade_upgrade_tiny_flat_black"></i>
		</div>
	</div>
	<div class="amountContainer" ng-if="!hideAmountContainer">
		<div class="amount" ng-show="itemObject.data.amount > 1">
			<div class="digit">{{itemObject.data.amount}}</div>
		</div>
		<span class="upgradeLevel"
			  ng-show="	(	itemObject.data.upgradeLevel > 0 &&	(
								itemObject.data.slot == heroItem.SLOT_LEFT_HAND ||
								itemObject.data.slot == heroItem.SLOT_BODY ||
								itemObject.data.slot == heroItem.SLOT_SHOES ||
								itemObject.data.slot == heroItem.SLOT_HELMET ||
								itemObject.data.slot == heroItem.SLOT_RIGHT_HAND
							) || (
								itemObject.data &&
								showNextUpgrade
							)
						) &&
			  			!hideUpgradeContainer
			  			">
			<i ng-repeat="a in []|range:1:5" class="upgrade_{{a > itemObject.nextUpgradeLevel  ? 'upgrade_tiny_flat_black' : heroItem.IconName['Slot'+itemObject.data.slot]+'_tiny_illu'}}" ng-if="showNextUpgrade"></i>
			<i ng-repeat="a in []|range:1:5" class="upgrade_{{a > itemObject.data.upgradeLevel ? 'upgrade_tiny_flat_black' : heroItem.IconName['Slot'+itemObject.data.slot]+'_tiny_illu'}}" ng-if="!showNextUpgrade"></i>
		</span>
	</div>

</div></script>
<script type="text/ng-template" id="tpl/hero/partials/itemDescriptionDirective.html"><div class="itemDescription">
	<div translate options="{{itemType}}" class="heroItemName">Hero.Item_?</div>
	<div ng-hide="instantUse || hideInfo || !hasBonuses">
		<div class="horizontalLine"></div>
		<span ng-repeat="(i,v) in bonuses track by $index">
			<span translate options="{{i}}"
					   data="x:{{v}}">
				Hero.ItemBonus_?
			</span><br>
		</span>
	</div>

	<div ng-show="instantUse && (itemType > heroItem.TYPE_CROP_BONUS_5 || itemType < heroItem.TYPE_RESOURCE_BONUS_3) && itemType != heroItem.TYPE_ARTWORK">
		<div class="horizontalLine"></div>
		<span translate options="{{itemType}}">
			Hero.ItemBonusInstantUse_?
		</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_ARTWORK">
		<div class="horizontalLine"></div>
		<span translate options="{{heroItem.TYPE_ARTWORK}}" data="maxCulture:{{bonuses[heroItem.BONUS_CULTURE_POINTS]}}">
			Hero.ItemBonusInstantUse_?
		</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_BANDAGE_25">
		<div class="horizontalLine"></div>
		<span translate>Hero.ItemBonusBandage25</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_BANDAGE_33">
		<div class="horizontalLine"></div>
		<span translate>Hero.ItemBonusBandage33</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_CAGES">
		<div class="horizontalLine"></div>
		<span translate>Hero.ItemBonusCages</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_BANDAGE_25_UPGRADED">
		<hr>
		<span translate>Hero.ItemBonusBandage30</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_BANDAGE_33_UPGRADED">
		<hr>
		<span translate>Hero.ItemBonusBandage38</span>
	</div>

	<div ng-show="itemType == heroItem.TYPE_HEALING_POTION">
		<hr>
		<span translate>Hero.ItemBonusPotion</span>
	</div>

	<div ng-show="itemType <= heroItem.TYPE_CROP_BONUS_5 && itemType >= heroItem.TYPE_RESOURCE_BONUS_3">
		<div class="horizontalLine"></div>
		<span translate ng-repeat="bonus in bonuses" data="x:{{bonus}}">Hero.ItemBonusResourceChest</span>
	</div>

	<div ng-show="perDay.max || perDay.maxWithoutLock">
		<div class="horizontalLine"></div>
		<span translate ng-show="consumable">Hero.ItemInstantUse</span>
		<br/>
		<span translate ng-show="perDay.max && !perDay.maxWithoutLock"
				   data="maxPerDay:{{perDay.max}},usedPerDay:{{perDay.used}}"
				   ng-class="{error:(perDay.used >= perDay.max)}">Hero.ItemInstantDailyUse
		</span>
		<span translate ng-show="!perDay.max && perDay.maxWithoutLock"
				   data="maxPerDay:{{perDay.maxWithoutLock}},usedPerDay:{{perDay.used}}"
				   ng-class="{error:(perDay.used >= perDay.maxWithoutLock)}">Hero.ItemInstantDailyUseWithoutLock
		</span>
	</div>

	<div ng-if="unitName">
		<div class="horizontalLine"></div>
		<span translate data="x:{{bonusUnitStrength}},name:{{unitName}}">Hero.ItemBonus_11</span>
	</div>

	<div ng-if="itemType == heroItem.TYPE_CAGES">
		<div class="horizontalLine"></div>
		<span translate>Hero.ItemCagesNoFight</span>
	</div>

	<div class="upgradeBonus" ng-if="upgradeBonus.level > 0">
		<div class="horizontalLine"></div>
		<div>
			<span translate data="current:{{upgradeBonus.level}}, max:{{upgradeBonus.maxUpgrades}}">
				Hero.UpgradeLevel
			</span>
			<span class="upgradeLevel">
				<i ng-repeat="a in []|range:1:5" class="upgrade_{{a > upgradeBonus.level ? 'upgrade_tiny_flat_black' : heroItem.IconName['Slot'+upgradeBonus.slot]+'_tiny_illu'}}"></i>
			</span>
		</div>
		<div>
			<span translate options="{{upgradeBonus.type}}"
					   data="x:{{upgradeBonus.value}}"
				>
				Hero.ItemUpgradeBonus_?
			</span><br>
		</div>

	</div>

</div></script>
<script type="text/ng-template" id="tpl/hero/partials/itemFilter.html"><a class="filter iconButton"
   ng-class="{active:type==showItemsType}"
   clickable="itemFilter(type)"
   ng-repeat="type in types"
   tooltip tooltip-translate="Hero.Item_{{type}}">
	<i class="filterItem heroItem item_category_{{iconNames[type]}}_small_flat_black"></i>
</a></script>
<script type="text/ng-template" id="tpl/hero/partials/itemTooltip.html"><div ng-if="notUsableItem != 'false' && notUsableReason != null && notUsableReason != ''">
	<div class="error">
		<span translate options="{{notUsableReason}}">Hero.Attributes.?</span>
		<div class="horizontalLine"></div>
	</div>
</div>

<div item-description="{{id}}" auction-item="{{auctionItem}}" hide-info="{{hideInfo}}"></div></script>
<script type="text/ng-template" id="tpl/hero/partials/resBonusPointsTooltip.html"><h3 translate>Hero.Attributes.resBonusPoints</h3>
<div class="horizontalLine"></div>
<span translate>Hero.Attributes.TooltipResBonusPointsDescription</span><br>
<div class="horizontalLine"></div>
<span translate>Hero.Attributes.TooltipResBonusPointsValues</span><br>
<span ng-if="val4 == 0"><i class="unit_resources_small_illu"></i> {{val5}} <span translate>resourcesAll</span></span>
<span ng-if="val4 == 1"><i class="unit_wood_small_illu"></i> {{val6}} <span translate>wood</span></span>
<span ng-if="val4 == 2"><i class="unit_clay_small_illu"></i> {{val6}} <span translate>clay</span></span>
<span ng-if="val4 == 3"><i class="unit_iron_small_illu"></i> {{val6}} <span translate>iron</span></span></script>
<script type="text/ng-template" id="tpl/hero/partials/xpTooltip.html"><h3 translate>Hero.Experience</h3>
<div class="horizontalLine"></div>
<span translate data="perc:{{xpPerc}}">Hero.ExperiencePercent</span><br>
<span translate data="xpToNextLevel:{{xpToNextLevel}},nextLevel:{{nextLevel}}">Hero.ExperienceToNextLevel</span>
<span ng-if="bonusXp != ''" >
	<div class="horizontalLine"></div>
	<span translate data="bonusXp:{{bonusXp}}">Hero.ExperienceBonus</span>
</span></script>
<script type="text/ng-template" id="tpl/hero/tabs/Adventures.html"><div ng-include="'tpl/questBook/tabs/OpenQuests.html'" onload="onlyAdventures = true" class="questBook"></div>
</script>
<script type="text/ng-template" id="tpl/hero/tabs/Attributes.html"><div class="heroProperties" ng-controller="attributesCtrl">
	<div scrollable height-dependency="max">
		<div class="contentBox gradient heroReviveBox" ng-if="hero.status >= HeroModel.STATUS_DEAD">
			<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
				<i class="attribute_dead_medium_flat_black"></i>
				<div class="content" translate>Hero.ReviveHeadline</div>
			</h6>
			<div class="contentBoxBody heroRevive" ng-if="hero.status >= HeroModel.STATUS_DEAD">
				<div class="reviveText">
					<span translate ng-if="hero.status == HeroModel.STATUS_DEAD">Hero.ReviveInVillage</span>
					<span translate ng-if="hero.status == HeroModel.STATUS_REVIVING" data="homeVillage: {{homeVillageName}}">Hero.Revive</span>
				</div>
				<div class="reviveCosts" ng-if="hero.status == HeroModel.STATUS_DEAD">
					<span>
						<display-resources resources="hero.reviveCosts"></display-resources>
						<i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="Duration"></i> {{hero.reviveDuration|HHMMSS}}
					</span>
					<div class="reviveButtonContainer">
						<button clickable="revive()" ng-class="{disabled: !isRevivable()}">
							<span translate>Hero.Button.Revive</span>
						</button>
						<npc-trader-button class="npcTraderHeroRevive" type="heroRevive" costs="{{hero.reviveCosts}}"></npc-trader-button>
					</div>
				</div>
				<div ng-if="hero.status == HeroModel.STATUS_REVIVING" class="revivalDuration">
					<i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="Duration"></i>
					<span countdown="{{hero.untilTime}}"></span>
				</div>

				<div class="error" ng-if="reviveError">
					<i class="symbol_warning_tiny_flat_red"></i> {{reviveError}}
				</div>
			</div>
		</div>

		<table class="transparent heroTable">
			<tbody>
				<tr>
					<td>
						<div class="contentBox gradient heroInfo">
							<h6 class="contentBoxHeader headerWithArrowEndings glorious">
								<div class="content" translate>Hero.Headline</div>
							</h6>
							<div class="contentBoxBody">
								<div class="contentBox gradient double heroStats">
									<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
										<i class="heroLevel">
											<div translate>HUD.Hero.Level</div>
											<div>{{hero.level}}</div>
										</i>
										<i class="headerButton"
										   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
										   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
										   tooltip tooltip-translate="Hero.Attributes.Tooltip.EditHero"
										   clickable="openOverlay('heroEditor')"></i>
									</h6>
									<div class="contentBoxBody heroImageContainer">
										<avatar-image scale="0.66" player-id="{{playerId}}" size="big" dead="{{hero.notAlive}}"></avatar-image>
										<div ng-if="hero.health > 0" class="currentLocation"
											 ng-class="{atHome: hero.status == HeroModel.STATUS_IDLE,
											            moving: hero.status > HeroModel.STATUS_IDLE && hero.status < HeroModel.STATUS_SUPPORTING,
											            return: hero.status == HeroModel.STATUS_RETURNING}">
											<span ng-if="hero.status == HeroModel.STATUS_IDLE" translate>Hero.Attributes.AtHome</span>
											<div ng-if="hero.status != HeroModel.STATUS_IDLE" class="heroStatusContainer">
												<div><i class="heroStatus status{{hero.status}}"></i></div>
												<div class="statusText" translate options="{{hero.status}}"
													 data="duration: {{hero.untilTime}},
															villageId: {{hero.villageId}},
															homeVillage: {{homeVillageName}},
															destVillageId: {{hero.destVillageId}},
															destVillage: {{hero.destVillageName}},
															playerId: {{hero.destPlayerId}},
															playerName: {{hero.destPlayerName}}">
													Hero.Status_?
												</div>
											</div>
										</div>
									</div>
									<div class="statsContainer contentBox gradient">
										<div class="contentBoxBody">
											<div class="progressbarContainer healthBar">
												<span class="frontLabel">
													<i class="unit_health_small_flat_black"></i>
												</span>
												<div progressbar class="health"
															 perc="{{hero.health}}"
															 label="{{hero.health | bidiNumber:'percent':false:false}}"
															 tooltip
															 tooltip-url="tpl/hero/partials/healthTooltip.html">
												</div>
											</div>
											<div class="progressbarContainer xpBar">
												<span class="frontLabel">
													<i class="unit_experience_small_flat_black"></i>
												</span>
												<div progressbar class="xp"
															 perc="{{hero.xpPerc}}"
															 label="{{hero.xp | bidiNumber:'HUD.Hero.ExperienceUnit':false:false}}"
															 tooltip
															 tooltip-url="tpl/hero/partials/xpTooltip.html"
															 tooltip-data="bonusXp:{{hero.bonusXp}},
												xpPerc:{{hero.xpPerc}},
												xpToNextLevel:{{hero.xpToNextLevel}},
												nextLevel:{{hero.nextLevel}}">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="contentBox gradient heroLocation">
									<div class="contentBoxBody">
										<div><i class="village_village_small_flat_black"></i>
											<span translate data="villageId: {{hero.villageId}}, homeVillage: {{homeVillageName}}">Hero.Attributes.HomeVillage</span>
										</div>
										<div><i class="unit_speed_small_flat_black" tooltip tooltip-translate="Hero.Attributes.Tooltip.HeroSpeed"></i>
											<span translate data="speed: {{hero.speed}}">Troops.Speed.Value</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
					<td>
						<div class="contentBox gradient heroAttributes">
							<h6 class="contentBoxHeader headerWithArrowEndings">
								<div class="content" translate>Hero.Attributes.Headline</div>
								<div class="freePoints">
									<span tooltip tooltip-translate="Hero.Attributes.FreePoints">{{freePoints}}</span>
									<i class="symbol_star_small_illu" ng-if="freePoints" tooltip tooltip-translate="Hero.Attributes.FreePoints"></i>
								</div>
							</h6>
							<div class="attributesList">
								<div class="attribute" ng-repeat="name in attributes" ng-class="{disabled: disabledAttributes[name]}"
									 tooltip
									 tooltip-url="tpl/hero/partials/{{name}}Tooltip.html"
									 tooltip-show="{{disabledAttributes[name]}}"
									 tooltip-data="val3:{{ valuePoints[name] * (hero[name]+changes[name])}},
											disabled:{{disabledAttributes[name]}}">
									<i class="attributeImage  {{name}}"
										 ng-class="{
										    attribute_defense_large_illu: name == 'defBonusPoints',
											attribute_offense_large_illu: name =='attBonusPoints',
											attribute_resources_large_illu: name == 'resBonusPoints',
											attribute_strength_large_illu: name == 'fightStrengthPoints'
										 }"
										 tooltip
										 tooltip-url="tpl/hero/partials/{{name}}Tooltip.html"
										 tooltip-hide="{{disabledAttributes[name]}}"
										 tooltip-data="val1:{{valuePoints[name] * (4+hero[name]+changes[name])}},
											val2:{{hero.bonuses[13]}},
											val3:{{ valuePoints[name] * (hero[name]+changes[name])}},
											val4:{{changes.resBonusType}},
											val5:{{valuePoints.resBonusAll * (hero.resBonusPoints + changes.resBonusPoints)}},
											val6:{{valuePoints.resBonusSingle * (hero.resBonusPoints + changes.resBonusPoints)}},
											disabled:{{disabledAttributes[name]}}">
									</i>
									<div class="attributeData">
										<span class="attributeName" translate options="{{name}}">Hero.Attributes.?</span>
									<span class="attributeValue" ng-if="name == 'attBonusPoints' || name == 'defBonusPoints'">
										{{ valuePoints[name] * (hero[name]+changes[name]) | bidiNumber:'percent':false:false:null:null:1 }}
									</span>
									<span class="attributeValue" ng-if="name == 'fightStrengthPoints'">
										{{ valuePoints[name] * (valuePoints.fightStrengthBaseLevel+hero[name]+changes[name]) + hero.bonuses[HeroItem.BONUS_FIGHT_STRENGTH] | number:0 }}
									</span>
									<span class="attributeValue" ng-if="name == 'resBonusPoints'">
										{{ valuePoints[name] * (hero[name]+changes[name]) | number:0 }}
									</span>

										<div class="attributeBar">
											<number-adjuster number-model="changes[name]" min="0" max="{{maxFreePoints[name]}}">
												<div progressbar perc="{{hero[name]}}" additional-perc="{{changes[name]}}" label="{{0|bidiRatio:(hero[name]+(changes[name]>0 ? (' + '+changes[name]) : '')):'100':true:false:true}}"></div>
											</number-adjuster>
										</div>
									</div>
									<p class="attributeDisabled" ng-show="disabledAttributes[name]" translate data="level: 10">Hero.Attributes.Disabled</p>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="contentBox gradient resourceProductionBox" ng-if="hero.status < HeroModel.STATUS_DEAD">
			<div class="contentBoxBody">
				<div class="headline" translate>
					Hero.Production
				</div>
				<div class="resourceOptions">
					<a class="resourceType clickableContainer" ng-class="{active: changes.resBonusType == $index}" ng-repeat="type in resTypes" clickable="changeResourceType($index)">
						<i ng-class="{unit_resourcesAndCrop_small_illu: type == 'resourcesAll'}"
						   class="unit_{{type}}_small_illu" tooltip tooltip-translate="{{type}}"></i>

						<div class="horizontalLine double"></div>
						{{valuePoints[$first?'resBonusBaseAll':'resBonusBaseSingle'] + valuePoints[$first?'resBonusAll':'resBonusSingle'] * (hero.resBonusPoints + changes.resBonusPoints)}}
						<i class="resourceSelected action_check_small_flat_white" ng-if="hero.resBonusType == $index"></i>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="saveChanges">
		<button clickable="saveChanges();" ng-class="{disabled: saveBtnDisabled}">
			<span translate>Hero.Attributes.SaveBtn</span>
		</button>
	</div>
	<div class="clear"></div>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/Auctions.html"><div ng-controller="auctionsCtrl">
	<div tabulation tab-config-name="auctionsTabs" ng-if="!isSitter">
		<div ng-include="tabBody_subtab"></div>
	</div>
	<span ng-if="isSitter" translate>
		Sitter.DisabledAsSitter
	</span>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/CardGame.html"><div class="cardGame contentBox unselectable" ng-controller="cardGameCtrl">
	<div class="contentBoxBody">
		<div class="cardGameContentWrapper">
			<div class="cardGameContent">
				<div class="dialogActor">
					<div class="dialogActorPortrait">
						<img ng-src="layout/images/x.gif" class="cardGame_fortuneTeller_huge_illu" />
					</div>
					<div class="tooltip textBubble after show">
						<div ng-show="currentState == gameStates.initial" class="tooltipContent ownText" translate data="playerName: {{player.data.name}}">CardGame.TextBubble.Welcome</div>
						<div ng-show="currentState == gameStates.startPlay" class="tooltipContent ownText" translate>CardGame.TextBubble.ContinuePlay</div>
						<div ng-show="currentState == gameStates.selectCard" class="tooltipContent ownText" translate>CardGame.TextBubble.ChooseCard</div>
						<div ng-show="currentState == gameStates.play4of5selectCards || currentState == gameStates.play4of5GainCards" class="tooltipContent ownText" translate>CardGame.TextBubble.play4of5</div>
						<div ng-show="currentState == gameStates.yourWonCard || currentState == gameStates.discardedCards || currentState == gameStates.discardedCardsRemove" class="tooltipContent ownText" translate>CardGame.TextBubble.DiscardedCards</div>
					</div>
				</div>
				<div class="freePlayIndicatorWrapper">
					<div class="freePlayIndicatorBackground">
						<div class="freePlayIndicator">
							<div class="freePlayIndicatorContent" tooltip tooltip-url="tpl/hero/partials/cardgameFreePlayTooltip.html">
								<div ng-show="currentState != gameStates.play4of5selectCards && cardgameRolls.data.freeRolls < 1"
									 data="nextFreePlay:{{midnight}}"
									 translate>CardGame.NextFreePlay</div>
								<div ng-show="currentState != gameStates.play4of5selectCards && cardgameRolls.data.freeRolls >= 1" class="freePlays">
									<div class="freePlayAmount">&times;{{cardgameRolls.data.freeRolls}}</div>
									<span translate>CardGame.FreePlaysLeft</span>
								</div>
								<div ng-show="currentState == gameStates.play4of5selectCards" class="selectCards">
									<div ng-repeat="index in [1, 2, 3, 4]"
										 class="cardSelectedIndicator"
										 ng-class="{cardGame_cardGame_medium_flat_black: amountChosen4of5 < index, cardGame_cardGame_medium_flat_green: amountChosen4of5 >= index}"></div>
									<div>{{0 | bidiRatio:amountChosen4of5:amountMax4of5}}</div>
								</div>
							</div>
						</div>
						<div class="arrow"></div>
					</div>
				</div>
				<div class="cardsWrapper">
					<div class="cardHolder" ng-show="currentState != gameStates.play4of5selectCards">
						<span translate ng-show="currentState == gameStates.discardedCards">CardGame.ClickContinue</span>
						<span ng-show="currentState <= gameStates.selectCard">
							<span translate ng-show="cardgameRolls.data.freeRolls > 0">CardGame.PlayForFree</span>
							<span translate ng-show="cardgameRolls.data.freeRolls == 0" data="cost: {{goldCost.cardgameSingle}}">CardGame.PlayCardgameSingle</span>
						</span>
					</div>
					<div ng-repeat="index in [1, 2, 3, 4, 5]"
						 ng-class="{disabled: disablePremium,
						  dealCards: currentState <= gameStates.selectCard,
						  chosen: index == chosenCard && currentState == gameStates.yourWonCard,
						  chosen4of5: chosenCards4of5[index - 1] && currentState == gameStates.play4of5selectCards,
						  showRemainingChosen: currentState == gameStates.discardedCards && index == chosenCard,
						  showRemainingDiscarded: currentState == gameStates.discardedCards && index != chosenCard,
						  discardRemaining: currentState == gameStates.discardedCardsRemove && index != chosenCard,
						  hide: currentState == gameStates.discardedCardsRemove && (index == chosenCard || chosenCards4of5[index - 1]),
						  freePlay: iconClasses[cardResults[index].rewardTypeId] == 'prize_freePlay_huge_illu',
						  goldOrSilver: iconClasses[cardResults[index].rewardTypeId] == 'prize_gold_huge_illu' || iconClasses[cardResults[index].rewardTypeId] == 'prize_silver_huge_illu',
						  selectable: currentState == gameStates.play4of5selectCards,
						  gain4of5: currentState == gameStates.play4of5GainCards && chosenCards4of5[index - 1],
						  showAll: currentState == gameStates.play4of5GainCards}"
						 class="card pos{{index}}"
						 premium-feature="{{premiumFeatureNameSingle}}"
						 premium-callback-param="{{index}}"
						 on-pointer-over="cardHoverStart()"
						 on-pointer-out="cardHoverStop()"
						 confirm-gold-usage="true">
						<div class="hoverWrapper">
							<div class="front cardContentWrapper cardGame_cardFront_illustration" clickable="chooseCard4of5(index)" ng-class="{disabled: currentState != gameStates.play4of5selectCards}">
								<span translate class="title" options="{{cardResults[index].rewardTypeId}}">CardGame.Card.Title_?</span>
								<div class="amountContainer" ng-if="cardResults[index].rewardAmount > 1 && cardResults[index].rewardAmount <= 99 && noAmountStarTypes.indexOf(cardResults[index].rewardTypeId) < 0">
									<i class="cardGame_amountStar_large_illu"></i>
									<span>x{{cardResults[index].rewardAmount}}</span>
								</div>
								<div class="icon {{iconClasses[cardResults[index].rewardTypeId]}}"></div>
								<span translate class="description" options="{{cardResults[index].rewardTypeId}}" data="amount: {{cardResults[index].rewardAmount}}">CardGame.Card.Description_?</span>
							</div>
							<div class="back cardGame_cardBack_illustration"></div>
						</div>
					</div>
				</div>
				<div class="cardGame4of5ButtonWrapper" ng-class="{showButton: currentState != gameStates.play4of5selectCards}">
					<button class="premium cardGame4of5Button"
							ng-show="currentState != gameStates.discardedCards && currentState != gameStates.play4of5selectCards"
							ng-class="{disabled: disablePremium}"
							premium-feature="{{premiumFeatureName4of5}}"
							tooltip tooltip-translate="CardGame.Button.CardGame4of5.tooltip">
						<span translate>CardGame.Button.CardGame4of5.Play</span>
					</button>
					<button ng-show="currentState == gameStates.discardedCards && currentState != gameStates.play4of5selectCards"
							class="continueButton"
							clickable="resetToStartPlay()"
							tooltip tooltip-translate="CardGame.Button.Continue.tooltip">
						<span translate>CardGame.Button.Continue</span>
					</button>
				</div>
				<div ng-show="currentState == gameStates.yourWonCard" class="backgroundOverlay darkener"></div>
				<div ng-show="currentState == gameStates.yourWonCard" class="backgroundOverlay clickWrapper" clickable="continue()"></div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/hero/tabs/Inventory.html"><div class="heroInventory" ng-controller="inventoryCtrl">
	<div class="contentBox previewBox gradient double" on-pointer-over="showSlots=true" on-pointer-out="showSlots=false">
		<div class="contentBoxHeader headerWithArrowEndings glorious">
			<div class="content" translate>Hero.Headline</div>
		</div>
		<div class="contentBoxBody">
			<div class="bodyItems" dropable="checkDrop(object)">
				<div ng-repeat="slot in [] | range:1:7" class="bodyItem slot{{slot}} {{avatar.gender}}"
					 ng-class="{clickable: heroEquipment[slot].data && heroEquipment[slot].data.id > 0,
					 			highlight: slot == highlightedSlot}"
					 ng-show="showSlots || slot == highlightedSlot || slot == 7"
					 on-pointer-over="changeSlotHighlight(slot)"
					 on-pointer-out="changeSlotHighlight(0)">
					<div class="innerWrapper">
						<div class="topLeftBorder"></div>
						<div class="bottomRightBorder"></div>
						<span ng-if="heroEquipment[slot]">
							<hero-item-container
								item="heroEquipment[slot]"
								drag-obj="dragObj"
								highlight-obj="highlightObj"
								click-callback="disequip"
								hide-equipped="true"
								highlighted="slot == highlightedSlot"
								></hero-item-container>
						</span>
					</div>
				</div>
			</div>
			<div class="heroImage" dropable="checkDrop(object)">
				<hero-image-file class="heroBody" file="{{avatar.gender+'/body/330x422/'+'base0'}}"></hero-image-file>

				<div class="faceOffset {{avatar.gender}}">
					<avatar-image player-id="{{playerId}}"
								  hide-hair="heroEquipment[HeroItem.SLOT_HELMET]"
								  hide-ears="heroEquipment[HeroItem.SLOT_HELMET]"
								  no-shoulders="true"></avatar-image>
				</div>
				<span ng-repeat="slot in [] | range:1:7" ng-if="heroEquipment[slot] || slot == HeroItem.SLOT_RIGHT_HAND || slot == HeroItem.SLOT_LEFT_HAND">
					<hero-image-file
							ng-if="heroEquipment[slot].data.images[0] && slot != HeroItem.SLOT_BAG"
							ng-style="{zIndex: heroEquipment[slot].data.zIndex}"
							ng-class="{slotBag: heroEquipment[slot].data.stackable}"
							file="{{avatar.gender+'/body/330x422/'+heroEquipment[slot].data.images[0]}}"></hero-image-file>
					<hero-image-file
						ng-if="!heroEquipment[slot] && slot == HeroItem.SLOT_RIGHT_HAND" class="heroRightHand"
						file="{{avatar.gender+'/body/330x422/'+'arm_right'}}"></hero-image-file>
					<hero-image-file
						ng-if="!heroEquipment[slot] && slot == HeroItem.SLOT_LEFT_HAND" class="heroLeftHand"
						file="{{avatar.gender+'/body/330x422/'+'arm_left'}}"></hero-image-file>
				</span>
			</div>
		</div>
		<div class="ground"></div>
	</div>
	<div class="contentBox inventoryBox">
		<div class="contentBoxHeader">
			<div class="content">
				<span translate>Hero.Inventory</span>
				<a class="filter iconButton"
				   ng-repeat="type in filterTypes"
				   ng-class="{active:activeFilter==type}"
				   clickable="setItemFilter(type)"
				   tooltip tooltip-translate="Hero.InventoryFilter_{{type}}">
					<i class="filterItem heroItem item_category_{{type}}_small_flat_black"></i>
				</a>
			</div>
		</div>
		<div scrollable class="contentBoxBody inventory">
			<div ng-if="!activeFilter">
				<hero-item-container ng-repeat="item in inventory | orderBy: 'data.inventorySlotNr'"
					item="item"
					drag-obj="dragObj"
					highlight-obj="highlightObj"
					click-callback="clickHandling"
					highlighted="item.data.slot == highlightedSlot || (item.data.itemType == HeroItem.TYPE_OINTMENT && highlightedSlot == HeroItem.SLOT_BAG)"
					hide-equipped="true"
					></hero-item-container>
			</div>
			<div ng-if="activeFilter">
				<hero-item-container ng-repeat="item in inventory | filter:itemFilter | orderBy: 'data.inventorySlotNr'"
					item="item"
					highlight-obj="highlightObj"
					click-callback="clickHandling"
					highlighted="item.data.slot == highlightedSlot || (item.data.itemType == HeroItem.TYPE_OINTMENT && highlightedSlot == HeroItem.SLOT_BAG)"
					hide-equipped="true"
					></hero-item-container>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/auctions/Bids.html"><div ng-if="player.data.deletionTime > 0" translate>Feature.NotPossibleInDeletion</div>
<div class="auction bids" ng-controller="auctionsBidsCtrl" ng-if="player.data.deletionTime == 0">
	<div class="filterBar">
		<item-filter func="filter"></item-filter>
	</div>
	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="cp">
		<table>
			<thead>
				<tr>
					<th colspan=2 translate>
						Auction.Description
					</th>
					<th>
						<i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="Duration"></i>
					</th>
					<th>
						<i class="feature_auction_small_flat_black" tooltip tooltip-translate="Auction.Bids"></i>
					</th>
					<th colspan="2" translate>
						Auction.Price
					</th>
					<th class="action" colspan="2" translate>
						Auction.Bid
					</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-if="auctions.length == 0">
					<td class="noAuctions" colspan="8" translate>Auction.NotFound</td>
				</tr>
				<tr ng-repeat="auction in auctions" ng-class="{error: auction.error, finished: auction.finished}">
					<td class="item">
						<item-icon auction-id="{{auction.id}}"
								   item-type="{{auction.itemTypeId}}"
								   auctionitem="true"
								   clickable="filter(auction.itemTypeId,true)"></item-icon>
					</td>
					<td>
						<span translate options="{{auction.itemTypeId}}">Hero.Item_?</span>
						<span ng-if="auction.stackable">({{auction.amount}}x)</span>
					</td>
					<td>
						<div ng-if="!auction.finished" countdown="{{auction.timeEnd}}"></div>
						<div ng-if="auction.finished" class="inactive" translate>Auction.Finished</div>
					</td>
					<td tooltip tooltip-translate="Auction.HighestBidder"
						tooltip-data="name: {{auction.highestBidderName}}">
						{{auction.bids}}
					</td>
					<td class="price" tooltip tooltip-translate="Auction.PriceProItem"
						tooltip-data="price: {{auction.pricePerItem}}"
						tooltip-hide="{{auction.amount <= 1}}">
						{{auction.price}} <i class="unit_silver_small_illu"></i>
					</td>
					<td>
						<i ng-class="{
							'feature_auction_small_flat_black disabled': auction.highestBidderPlayerId == 0,
							feature_auction_small_flat_positive: auction.highestBidderPlayerId == player.data.playerId,
							feature_auction_small_flat_negative: auction.highestBidderPlayerId != player.data.playerId
						}"></i>
					</td>
					<td class="priceInputCol">
						<input type="tel"
							   class="priceInput"
							   ng-model="auction.priceInput"
							   number="{{(player.data.silver+auction.highestBid)}}"
							   placeholder="{{auction.bidPlaceholder}}"
							   ng-disabled="auction.finished"
							   ng-class="{highestBidder: !auction.finished && auction.highestBidderPlayerId == player.data.playerId,
										  outbid: !auction.finished && auction.highestBidderPlayerId != player.data.playerId}">
					</td>
					<td class="bidButtonCol">
						<button ng-if="!auction.finished"
								clickable="placeBid({{auction.id}})"
								play-on-click="{{UISound.BUTTON_BET_ON_ITEM}}">
							<span translate>Auction.ChangeBid</span>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="error" ng-if="error" translate options="{{error}}" data="minBid:{{bid.minPrice+1}}">?</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/auctions/Buy.html"><div ng-if="player.data.deletionTime > 0" translate>Feature.NotPossibleInDeletion</div>
<div class="auction buy" ng-controller="auctionsBuyCtrl" ng-if="player.data.deletionTime == 0">
	<div class="filterBar">
		<item-filter func="filter"></item-filter>
	</div>
	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="cp">
		<table>
			<thead>
				<tr>
					<th colspan=2 translate>
						Auction.Description
					</th>
					<th>
						<i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="Duration"></i>
					</th>
					<th>
						<i class="feature_auction_small_flat_black" tooltip tooltip-translate="Auction.Bids"></i>
					</th>
					<th colspan="2" translate>
						Auction.Price
					</th>
					<th class="action" colspan="2" translate>
						Auction.Bid
					</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-if="auctions.data.length == 0">
					<td class="noAuctions" colspan="8" translate>Auction.NotFound</td>
				</tr>
				<tr ng-repeat="auction in auctions.data" ng-class="{error: auction.data.error}" ng-show="auction.data.timeEnd > currentServerTime">
					<td class="item">
						<item-icon auction-id="{{auction.data.id}}"
								   item-type="{{auction.data.itemTypeId}}"
								   auctionitem="true"
								   clickable="filter(auction.data.itemTypeId,true)"></item-icon>
					</td>
					<td>
						<span translate options="{{auction.data.itemTypeId}}">Hero.Item_?</span>
						<span ng-if="auction.data.stackable">({{auction.data.amount}}x)</span>
					</td>
					<td>
						<div countdown="{{auction.data.timeEnd}}"></div>
					</td>
					<td tooltip
						tooltip-data="name: {{auction.data.highestBidderName}}"
						tooltip-translate-switch="{
							'Auction.HighestBidder': {{auction.data.highestBidderPlayerId > 0}},
							'Auction.NoBids': {{auction.data.highestBidderPlayerId <= 0}}
						}">
						{{auction.data.bids}}
					</td>
					<td class="price" tooltip tooltip-translate="Auction.PriceProItem"
						tooltip-data="price: {{auction.data.pricePerItem}}"
						tooltip-hide="{{auction.data.amount <= 1}}">
						{{auction.data.price}} <i class="unit_silver_small_illu"></i>
					</td>
					<td>
						<i ng-class="{
							'feature_auction_small_flat_black disabled': auction.data.highestBidderPlayerId == 0,
							feature_auction_small_flat_positive: auction.data.highestBidderPlayerId == player.data.playerId,
							feature_auction_small_flat_negative: hasBidById[auction.data.id] && auction.data.highestBidderPlayerId != player.data.playerId
						}"></i>
					</td>
					<td class="priceInputCol">
						<input class="priceInput"
							   ng-model="auction.priceInput"
							   number="{{(player.data.silver+auction.data.highestBid)}}"
							   placeholder="{{auction.data.bidPlaceholder}}"
							   ng-class="{highestBidder: auction.data.highestBidderPlayerId == player.data.playerId,
										  outbid: hasBidById[auction.data.id] && auction.data.highestBidderPlayerId != player.data.playerId}">
					</td>
					<td class="bidButtonCol">
						<button clickable="placeBid({{auction.data.id}})"
								play-on-click="{{UISound.BUTTON_BET_ON_ITEM}}">
							<span translate ng-if="auction.data.highestBidderPlayerId != player.data.playerId">Auction.PlaceBid</span>
							<span translate ng-if="auction.data.highestBidderPlayerId == player.data.playerId">Auction.ChangeBid</span>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="error" ng-if="error" translate options="{{error}}" data="minBid:{{bid.minPrice}}">?</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/auctions/ExchangeOffice.html"><div ng-if="player.data.deletionTime > 0" translate>Feature.NotPossibleInDeletion</div>
<div class="contentBox exchangeOffice" ng-controller="exchangeOfficeCtrl" ng-if="player.data.deletionTime == 0">
	<div class="contentBoxBody">
		<div class="description" translate>ExchangeOffice.Description</div>
		<div class="column silverToGold">
			<h6 class="headerWithIcon arrowDirectionTo">
				<i class="unit_silver_medium_illu"></i>
				<i class="unit_gold_medium_illu"></i>
				<span translate>ExchangeOffice.changeSilverToGold</span>
			</h6>
			<div class="columnContent">
				<div class="exchangeRate">
					<span class="unimportant">&divide; {{exchangeSilver.getRate()}} =</span>
					<i class="unit_gold_small_illu"></i> {{exchangeSilver.result}}
				</div>
				<slider class="exchangeSlider"
						ng-class="{noSteps: exchangeSilver.getMaxAmount() > 10000}"
						icon-class="unit_silver_small_illu"
						slider-min="0"
						slider-max="exchangeSilver.getMaxAmount()"
						slider-steps="exchangeSilver.getRate()"
						slider-data="exchangeSilver.amount"
						slider-show-max-button="false"></slider>
				<button ng-class="{disabled: exchangeSilver.result == 0 || exchangeSilver.amount.value == 0}"
						premium-feature="{{PremiumFeatureName}}"
						premium-callback-param="silver"
						price="0"
						class="exchangeSubmit"
						tooltip tooltip-translate="{{silverToGoldButtonTooltip}}">
				<span translate>ExchangeOffice.exchange</span>
				</button>
			</div>
		</div>
		<div class="column goldToSilver">
			<h6 class="headerWithIcon arrowDirectionTo">
				<i class="unit_gold_medium_illu"></i>
				<i class="unit_silver_medium_illu"></i>
				<span translate>ExchangeOffice.changeGoldToSilver</span>
			</h6>
			<div class="columnContent">
				<div class="exchangeRate">
					<span class="unimportant">&times; {{exchangeGold.getRate()}} =</span>
					<i class="unit_silver_small_illu"></i> {{exchangeGold.result}}
				</div>
				<slider class="exchangeSlider"
						icon-class="unit_gold_small_illu"
						slider-min="0"
						slider-max="exchangeGold.getMaxAmount()"
						slider-data="exchangeGold.amount"
						slider-show-max-button="false"
						input-autofocus="true"></slider>
				<button ng-class="{disabled: exchangeGold.amount.value == 0}"
						class="exchangeSubmit premium"
						premium-feature="{{PremiumFeatureName}}"
						premium-callback-param="gold"
						tooltip
                        force-gold-usage="true"
						price="{{exchangeGold['amount']['value']}}"
						tooltip-translate="{{goldToSilverButtonTooltip}}">
				<span translate>ExchangeOffice.exchange</span>
				</button>
			</div>
		</div>
	</div>
	<div class="contentBoxFooter" ng-show="exchangeSuccess.message !== ''">
		<div class="success">
			<span translate data="silver:{{exchangeSuccess.silver}}, gold:{{exchangeSuccess.gold}}, silver_icon:unit_silver_small_illu, gold_icon:unit_gold_small_illu" options="{{exchangeSuccess.message}}">
				ExchangeOffice.success_?
			</span>
		</div>
		<div ng-if="exchangeError" class="error" translate data="param:{{exchangeErrorParam}}" options="{{exchangeError}}">
			?
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/auctions/Sell.html"><div ng-if="player.data.deletionTime > 0" translate>Feature.NotPossibleInDeletion</div>
<div class="auction sell" ng-controller="auctionsSellCtrl" ng-if="player.data.deletionTime == 0">
	<div class="contentBox gradient">
		<h6 class="contentBoxHeader headerWithArrowEndings">
			<div class="content" translate>
				Hero.Inventory
			</div>
		</h6>
		<div class="contentBoxBody unselectable" scrollable>
			<div class="emptyInventory" ng-if="inventory.length == 0 " translate>Auction.EmptyInventory</div>
			<div ng-if="inventory.length > 0 " class="items">
				<hero-item-container
					hide-item-states="true"
					hide-upgrade="true"
					item="item"
					ng-repeat="item in inventory"
					ng-show="item.data.itemType != HeroItem.TYPE_TREASURES"
					click-callback="clickHandling"
					highlight-obj="highlightObj"
					>
				</hero-item-container>
			</div>
		</div>
	</div>
	<div class="contentBox gradient">
		<h6 class="contentBoxHeader headerWithArrowEndings">
			<div class="content" translate>
				Auction.Sell
			</div>
		</h6>
		<div class="contentBoxBody">
			<div ng-if="!currentItem" class="noSelection" translate>Auction.PleaseSelectItem</div>
			<div ng-if="currentItem">
				<hero-item-container
					hide-item-states="true"
					hide-upgrade="true"
					item="currentItem"
					>
				</hero-item-container>

				<div class="descriptionWrapper" scrollable>
					<span ng-if="currentItem.auction"
						  item-description="{{currentItem.data.id}}"
						  auction-item="{{currentItem}}"
						  hide-instant-use="true"></span>
					<span ng-if="!currentItem.auction"
						  item-description="{{currentItem.data.id}}"
						  hide-instant-use="true"></span>
				</div>

				<div ng-if="currentItem.auction" class="inputFields">
					<div class="itemValue">
						<span translate>Auction.CurrentProceeds</span>
						<div>{{currentItem.data.price}} <i class="unit_silver_small_illu"></i></div>
					</div>
					<div ng-if="currentItem.data.stackable" class="auctionAmount">
						<span translate>Auction.Amount</span>
						<div>{{currentItem.data.amount}}</div>
					</div>
					<div class="auctionInfoContainer">
						<div class="auctionInfo">
							<span translate>Auction.TimeLeft</span>
							<div countdown="{{currentItem.data.timeEnd}}"></div>
						</div>
						<div class="auctionInfo">
							<span translate>Auction.CurrentBids</span>
							<div>{{currentItem.data.bids}}</div>
						</div>
					</div>
				</div>
				<div ng-if="!currentItem.auction" class="inputFields">

					<div ng-if="isNpcBuying" class="itemValue">
						<span translate>Auction.Value</span>
						<div><i class="unit_silver_small_illu"></i> {{price}}</div>
					</div>
					<div ng-if="currentItem.data.stackable && maxAmount >= 2" class="amount">
						<div class="amountHeader" translate>Auction.Amount</div>
						<slider slider-min="1" slider-max="maxAmount" slider-data="sellAmount" input-autofocus="true"></slider>
					</div>
					<div class="totalValue" ng-if="isNpcBuying && currentItem.data.stackable">
						<span translate>Auction.Total</span>
						<div><i class="unit_silver_small_illu"></i> {{totalAmount}}</div>
					</div>
					<div ng-if="!isNpcBuying" class="directAuctionDescription">
						<span translate>Auction.DirectAuctionExplanation</span>
						<span class="ticker" countdown="{{calcTimeEnd}}"></span>
					</div>

					<div class="sellButtonContainer" ng-if="isNpcBuying">
						<button clickable="sellItem()">
							<span translate>Auction.Sell</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/hero/tabs/auctions/Silver.html"><div ng-controller="auctionsSilverBookkeepingCtrl">
	<table class="silverBookkeeping fixedTableHeader" scrollable height-dependency="max">
		<thead>
		<tr>
			<td translate class="date">Auction.SilverDate</td>
			<td translate class="description">Auction.SilverDescription</td>
			<td translate class="amount">Auction.SilverAmount</td>
			<td translate class="balance">Auction.SilverBalance</td>
		</tr>
		</thead>
		<tbody>
		<tr class="highlightRow">
			<td class="date">-</td>
			<td class="silverBlockedDescription description">
				<span translate ng-if="silverBlockingAuctions.data.length > 0"
						   data="auctions: {{silverBlockingAuctions.data.length}}">Auction.SilverBlockedInAuctions
				</span>
				<span translate ng-if="silverBlockingAuctions.data.length == 0">Auction.SilverNoneBlockedInAuctions</span>
				<span clickable="switchShowBlockedSilver()"
					  tooltip-show="{{silverBlockingAuctions.data.length > 0}}"
					  tooltip
					  tooltip-translate="{{showBlockedSilver && 'Auction.HideBlockedSilverDetails' || 'Auction.ShowBlockedSilverDetails'}}"
					  ng-class="{disabled: silverBlockingAuctions.data.length == 0}">
					<a ng-if="!showBlockedSilver" ng-class="{disabled: silverBlockingAuctions.data.length == 0}" translate>Auction.ShowMore</a>
					<a ng-if="showBlockedSilver" ng-class="{disabled: silverBlockingAuctions.data.length == 0}" translate>Auction.ShowLess</a>
				</span>
			</td>
			<td class="amount"><span ng-if="blockedSilver>0">-</span>{{blockedSilver}}</td>
			<td class="balance">{{player.data.silver}}</td>
		</tr>

		<tr ng-show="showBlockedSilver" ng-repeat="auction in silverBlockingAuctions.data">
			<td class="silverBlockedDescription" colspan="2">
				<span class="indentedDescription">
					<item-icon auction-id="{{auction.data.id}}" item-type="{{auction.data.itemTypeId}}" auctionitem="true"></item-icon>
					{{auction.data.amount}} x <span translate options="{{auction.data.itemTypeId}}">Hero.Item_?</span>
				</span>
			</td>
			<td class="amount">-{{auction.data.highestBid}}</td>
			<td class="balance"></td>
		</tr>

		<tr ng-repeat="event in silverEvents.data | orderBy:['-data.time','-data.id']">
			<td class="date">
				<span i18ndt="{{event.data.time}}" format="shortDate"></span>
			</td>
			<td class="description">
				<div ng-if="event.data.operationType == 1">
					<span ng-if="event.data.operationType == 1 && event.data.silver < 0" translate>Auction.BoughtGold</span>
					<span ng-if="event.data.operationType == 1 && event.data.silver > 0" translate>Auction.BoughtSilver</span>
				</div>
				<div ng-if="event.data.operationType == 2 || event.data.operationType == 3">
					<span translate ng-if="event.data.silver > 0">Auction.SilverObtained</span>
					<span translate ng-if="event.data.silver < 0">Auction.SilverPayed</span>

					<item-icon auction-id="{{auction.data.id}}" item-type="{{event.data.itemType}}" auctionitem="true"></item-icon>
					{{event.data.itemAmount}} x
					<span translate options="{{event.data.itemType}}">Hero.Item_?</span>
				</div>
				<div ng-if="event.data.operationType == 4">
					<span translate>Auction.SilverFromAdventure</span>
				</div>
			</td>
			<td class="amount"><span ng-if="event.data.silver > 0">+</span>{{event.data.silver}}</td>
			<td class="balance">{{event.data.calcPreviousSilver}}</td>
		</tr>

		<tr class="highlightRow">
			<td colspan="3" class="oldBalanceDescription">
				<span translate>Auction.OldBalance</span>
				(<span i18ndt="{{currentServerTime - 7*24*60*60}}" format=" mediumDate"></span>)
			</td>
			<td class="balance">{{startingBalance}}</td>
		</tr>
		</tbody>
	</table>

	<div class="italic grey">(
		<span translate>Auction.SalesForLastSevenDays</span>
		)
	</div>
</div></script>
<script type="text/ng-template" id="tpl/igm/igm.html"><div ng-controller="igmSystemCtrl" class="igmSystem">
	<div class="firstHalf">
		<div class="background"></div>
		<div class="newThreadContainer">
			<div ng-if="isBannedFromMessaging && bannedFromMessagingUntil == -1" class="clickableContainer disabled" tooltip tooltip-translate="Chat.BannedFromMessaging.Tooltip.Infinite">
				<span translate>Chat.StartConversation</span>
			</div>
			<div ng-if="isBannedFromMessaging && bannedFromMessagingUntil > 0" class="clickableContainer disabled" tooltip tooltip-translate="Chat.BannedFromMessaging.Tooltip.Until" tooltip-data="timeFinish:{{bannedFromMessagingUntil}}">
				<span translate>Chat.StartConversation</span>
			</div>

			<div ng-if="!isActivated && !isBannedFromMessaging" class="clickableContainer disabled" tooltip tooltip-translate="Chat.IsNotActivated">
				<span translate>Chat.StartConversation</span>
			</div>

			<div ng-if="!isBannedFromMessaging && isActivated" class="clickableContainer" clickable="newThread()" tooltip tooltip-translate="Chat.StartConversation.Tooltip">
				<span translate>Chat.StartConversation</span>
				<div class="plusSign"><i class="symbol_plus_tiny_flat_white"></i></div>
			</div>
		</div>
		<div class="history" scrollable ng-click="setChatInputState(0)">
			<ul>
				<li ng-repeat-start="inboxEntry in filteredInbox" class="divider">
					<chat-time-divider class="noHoverEffect" last="{{filteredInbox[$index-1].data.lastTimestamp}}" current="{{inboxEntry.data.lastTimestamp}}"></chat-time-divider>
				</li>
				<li ng-repeat-end class="igmConversationEntry" clickable="openConversation(inboxEntry)"
					chat-igm-entry inbox-entry="inboxEntry"
					ng-class="{selected: selectedConversation.data.roomId == inboxEntry.data.roomId, new: inboxEntry.data.ownUnread}">

				</li>
				<div class="divider">
					<a clickable="loadOlderConversations()" ng-if="filteredInbox.length >= countConversationsDisplayed" translate>Chat.LoadOlderMessages</a>
				</div>
			</ul>
		</div>
	</div>
	<div class="threadView" ng-class="{filled: selectedConversation != null}">
		<div class="background" ng-if="selectedConversation == null"></div>
		<div class="conversationHeader" ng-class="{selected: selectedConversation != null}">
			<div class="arrow"></div>
			<div class="title truncated" translate ng-if="selectedConversation == null">Chat.Conversation.Title</div>
			<div class="title truncated" translate ng-if="selectedConversation != null" data="name:{{selectedConversation.data.roomViewName}}" options="{{selectedConversation.data.roomType}}">Chat.Conversation.With_?</div>
			<div class="menu" ng-if="selectedConversation != null">
				<div class="options" more-dropdown more-dropdown-options="getConversationOptions()"></div>
			</div>
		</div>
		<div ng-include src="'tpl/chat/chatRoomBody.html'" ng-if="selectedConversation != null" class="chatRoomBody" ng-class="{smaller: chatInputState>0}"></div>
		<div ng-if="selectedConversation != null"
			 tooltip class="openWrite"
			 tooltip-hide="(!isBannedFromMessaging && isActivated)"
			 tooltip-data="timeFinish:{{bannedFromMessagingUntil}}"
			 tooltip-translate-switch="{
						'Chat.BannedFromMessaging.Tooltip.Infinite': {{bannedFromMessagingUntil == -1}},
						'Chat.BannedFromMessaging.Tooltip.Until': {{bannedFromMessagingUntil > 0}}
						}">
			<div ng-disabled="isBannedFromMessaging || !isActivated" ng-if="selectedConversation != null && chatInputState == 0" clickable="setChatInputState(1)">
				<i class="writeMessage"></i>
				<div ng-if="isBannedFromMessaging" class="inputWrapper">
					<input ng-disabled="isBannedFromMessaging" type="text" placeholder="{{answerPlaceholder}}" ng-model="input.textToSend">
				</div>
				<div ng-if="!isBannedFromMessaging && !isActivated" class="inputWrapper">
					<input ng-disabled="!isActivated" type="text" placeholder="{{answerPlaceholder}}" ng-model="input.textToSend">
				</div>
				<div ng-if="!isBannedFromMessaging && isActivated" class="inputWrapper">
					<input type="text" placeholder="{{answerPlaceholder}}" ng-model="input.textToSend">
				</div>
			</div>
		</div>
		<div class="writeArea" ng-if="selectedConversation != null && chatInputState == 1">
			<div class="menu">
				<i class="close action_cancel_tiny_flat_black" clickable="setChatInputState(0)" tooltip tooltip-translate="Button.Close"></i>
			</div>
			<div class="inputTextAreaWrapper"
				 bb-code-input set-focus="true"
				 ng-model="input.textToSend" auto-expand="true" min-height="110" max-height="230">
			</div>
			<div class="buttonWrapper">
				<i class="writeMessage"></i>
				<button clickable="triggerSend()" ng-class="{disabled: input.textToSend == ''}">
					<span translate>Chat.SendMessage</span>
				</button>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/igm/igmEntry.html"><div class="igmAvatar">
	<avatar-image scale="0.5" player-id="{{::inboxEntry.data.playerId}}" avatar-class="profile" ng-if="::inboxEntry.data.playerId > 0"></avatar-image>
	<avatar-image scale="0.5" player-id="{{::inboxEntry.data.linePlayerId}}" avatar-class="profile" ng-if="::inboxEntry.data.playerId <= 0"></avatar-image>
	<i class="conversation_alliance_medium_flat_black groupConversationIcon" ng-if="::inboxEntry.data.group != '' && (inboxEntry.data.roomType == ChatRoom.TYPE_ALLIANCE || inboxEntry.data.roomType == ChatRoom.TYPE_ALLIANCE_LEADERS)"></i>
	<i class="conversation_kingdom_medium_flat_black groupConversationIcon" ng-if="::inboxEntry.data.group != '' && inboxEntry.data.roomType == ChatRoom.TYPE_KINGDOM"></i>
	<i class="conversation_secretSociety_medium_flat_black groupConversationIcon" ng-if="::inboxEntry.data.group != '' && inboxEntry.data.roomType == ChatRoom.TYPE_SECRET_SOCIETY"></i>
</div>
<div class="verticalLine"></div>
<div class="igmInfos">
	<div class="name roomType{{::inboxEntry.data.roomType}} truncated" ng-if="::inboxEntry.data.group == ''">
		{{inboxEntry.data.roomViewName}}
	</div>
	<div class="name roomType{{::inboxEntry.data.roomType}} truncated" ng-if="::inboxEntry.data.group != ''">
		<span translate ng-if="::inboxEntry.data.roomType == ChatRoom.TYPE_KINGDOM">Kingdom</span>
		<span translate ng-if="::inboxEntry.data.roomType == ChatRoom.TYPE_ALLIANCE || inboxEntry.data.roomType == ChatRoom.TYPE_ALLIANCE_LEADERS">Alliance</span>
		<div ng-if="::inboxEntry.data.roomType == ChatRoom.TYPE_SECRET_SOCIETY">{{::inboxEntry.data.roomViewName}}</div>
	</div>
	<div class="linePreview truncated" ng-if="::!short">
		<span ng-if="::inboxEntry.data.line" user-text-parse="inboxEntry.data.line" parse="decorations;linkings;reports;coordinates" ></span>
	</div>
	<div class="date" ng-if="::inboxEntry.data.timestamp && !short">
		<span i18ndt="{{::inboxEntry.data.timestamp / 1000}}" format="veryShort"></span>
	</div>
	<div class="readNotification" ng-if="inboxEntry.data.otherRead">
		<i class="action_check_tiny_flat_green" ng-if="inboxEntry.data.otherRead >= inboxEntry.data.totalParticipents" tooltip tooltip-translate="Chat.HasReadMessage"></i>
		<i class="action_check_tiny_flat_black gray" ng-if="inboxEntry.data.otherRead < inboxEntry.data.totalParticipents" tooltip tooltip-url="tpl/igm/readStatistic.html"></i>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/igm/igmSystemNewConversation.html"><div class="shareReport newIgmConversation">
	<div class="optionContainer">
		<div class="headerWithArrowDown">
			<div class="content" translate>Chat.Receiver</div>
		</div>
		<div class="clickableContainer" ng-class="{active: shareWith=='player'}" clickable="setShareWith('player')">
			<i class="community_friend_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<!--<input type="text"/>-->
			<serverautocomplete change-input="clearPlayerId()" autocompletedata="player" autocompletecb="selectSharePlayer" ng-model="shareWithPlayerName"></serverautocomplete>

			<div class="label" translate>Player</div>
			<div class="selectionArrow" ng-if="shareWith=='player'"></div>
		</div>
		<div class="clickableContainer" ng-disabled="user.data.kingdomId == 0"
			 ng-class="{active: shareWith=='kingdom'}"
			 tooltip tooltip-translate-switch="{'Chat.GroupDisabled.Kingdom': {{user.data.isKing == false}} }"
			 clickable="setShareWith('kingdom')">
			<i class="community_kingdom_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<div class="label" translate>Kingdom</div>
			<div class="selectionArrow" ng-if="shareWith=='kingdom'"></div>
		</div>
		<div class="clickableContainer" ng-disabled="user.data.allianceId == 0"
			 ng-class="{active: shareWith=='alliance', disabled: !user.data.isKing && !user.isDuke()}"
			 tooltip tooltip-translate-switch="{'Chat.GroupDisabled.Alliance': {{!user.data.isKing && !user.isDuke()}} }"
			 clickable="setShareWith('alliance')">
			<i class="community_alliance_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<div class="label" translate>Alliance</div>
			<div class="selectionArrow" ng-if="shareWith=='alliance'"></div>
		</div>
		<div class="clickableContainer" ng-disabled="societies.data.length == 0"
			 ng-class="{active: shareWith=='secretSociety', disabled: societies.data.length == 0}"
			 tooltip tooltip-translate-switch="{'Chat.GroupDisabled.Societies': {{societies.data.length == 0}} }"
			 clickable="setShareWith('secretSociety')">
			<i class="community_secretSociety_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<div dropdown ng-if="societies.data.length > 0" data="dropdownData"></div>
			<div class="label" translate>SecretSociety</div>
			<div class="selectionArrow" ng-if="shareWith=='secretSociety'"></div>
		</div>
	</div>

	<div class="commentContainer contentBox">
		<div class="contentBoxHeader headerWithArrowDown active">
			<div class="content" translate>Chat.Message</div>
		</div>
		<div class="contentBoxBody">
			<div ng-if="shareWith == 'alliance' && isAllianceLeader" class="shareToOnlyAdmin">
				<input type="checkbox" id="shareToOnlyAdmin" ng-model="input.adminOnly">
				<label for="shareToOnlyAdmin" translate>Chat.OnlyForAdmin</label>
			</div>
			<div class="shareMessage" bb-code-input ng-model="input.shareMessage">
		</div>
	</div>
	<div class="buttonContainer">
		<button clickable="share();" class="share" ng-class="{disabled:((shareWith=='player' && (!shareWithPlayerId || shareWithPlayerId == '')) || shareWith=='' || input.shareMessage =='') }">
			<span translate>Chat.CreateNewMessage</span>
		</button>
		<button clickable="closeOverlay();" class="cancel">
			<span translate>Button.Abort</span>
		</button>
	</div>
	<div ng-if="error">
		<i class="symbol_warning_tiny_flat_red"></i> <span class="error">{{error}}</span>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/igm/readStatistic.html"><div translate>Chat.PersonsReadMessage</div>
<div class="lineBreakLinkList" ng-if="inboxEntry != null">
	<span player-link ng-repeat="(playerId, timestamp) in inboxEntry.data.playersRead"
				 ng-if="playerId != inboxEntry.data.linePlayerId"
				 playerId="{{playerId}}" playerName=""></span>
</div>
<div class="lineBreakLinkList" ng-if="inboxEntry == null">
	<span player-link ng-repeat="(playerId, timestamp) in selectedConversation.data.playersRead"
				 ng-if="playerId != selectedConversation.data.linePlayerId"
				 playerId="{{playerId}}" playerName=""></span>
</div></script>
<script type="text/ng-template" id="tpl/infoPopup/infoPopup.html"><div class="infoPopup" ng-controller="infoPopupCtrl">
	<div class="description">
		<span translate options="{{context}}">Notification.Info.Text.?</span>
	</div>
	<div class="horizontalLine"></div>
	<div class="confirm" >
		<button clickable="closeWindow('infoPopup')">
			<span translate>Button.Ok</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/introduction/introduction.html"><div class="introductionText" ng-controller="helpMenuCtrl">
	<button clickable="openHelpCenter();" ng-if="inHelpMenu">
		<span translate>HelpCenter.Open</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/kingOrGovernor/kingOrGovernor.html"><div ng-controller="kingOrGovernorCtrl" class="contentBody"
	 ng-init="iconMap={'king':['roleSelect_experienced','roleSelect_defense','unit_treasure'],'governor':['roleSelect_everyone','unit_stolenGoods','roleSelect_strategy']}">
	<div class="header tutorial_kingOrGovernor_illustration"></div>
	<div class="role {{::role}}" ng-repeat="role in ['governor', 'king']">
		<div class="headerContainer">
			<div class="beginnersProtection">
				<span translate options="{{::role}}" data="days:{{config.balancing.NoobProtectionDays[role.ucfirst()]}}" class="days">KingOrGovernor.BeginnerProtection.Days_?</span>
				<div class="horizontalLine"></div>
				<span translate>KingOrGovernor.BeginnerProtection</span>
			</div>
		</div>

		<div class="contentBox">
			<h6 class="contentBoxHeader headerWithArrowEndings" ng-class="::{glorious: role == 'king'}">
				<div class="content">
					<span translate options="{{::role}}">KingOrGovernor.Role_?</span>
				</div>
			</h6>
			<div class="contentBoxBody">
				<div class="feature" ng-repeat="line in [1,2]" tooltip tooltip-translate="KingOrGovernor.Feature.Tooltip_{{::role}}_{{::line}}">
					<i class="{{::iconMap[role][line]}}_medium_illu"></i>
					<div class="description" translate options="{{::role}},{{::line}}">KingOrGovernor.Feature_?_?</div>
				</div>
				<div class="summary" tooltip tooltip-translate="KingOrGovernor.Feature.Tooltip.Recommendation_{{::role}}">
					<i class="{{::iconMap[role][0]}}_medium_illu"></i>
					<div translate options="{{::role}}" class="description">KingOrGovernor.Feature.Recommendation_?</div>
				</div>
			</div>
			<div ng-if="::role == 'governor'" class="buttonHighlight roleSelect_buttonBackground_layout"></div>
			<button clickable="selectRole(role)" ng-class="{disabled: role == 'king' && !hasEnoughPrestigeForGetAKing}">
				<span translate options="{{::role}}">KingOrGovernor.Confirm_?</span>
			</button>
			<div ng-if="::role == 'king' && !hasEnoughPrestigeForGetAKing" class="notEnoughPrestigeForKing">
				<div class="content" translate data="minPrestige: {{config.balancing.minPrestigeForGetAKing}}">KingOrGovernor.Confirm_king.NotEnoughPrestige</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/kingOrGovernor/kingOrGovernorSelected.html"><div class="kingOrGovernorSelected">
	<div class="role {{role}}">
		<div class="headerContainer tutorial_{{role}}_illustration">
			<div class="beginnersProtection">
				<span translate options="{{role}}" data="days:{{config.balancing.NoobProtectionDays[role.ucfirst()]}}" class="days">KingOrGovernor.BeginnerProtection.Days_?</span>
				<div class="horizontalLine"></div>
				<span translate>KingOrGovernor.BeginnerProtection</span>
			</div>
		</div>

		<h6 class="contentBoxHeader headerWithArrowEndings" ng-class="{glorious: role == 'king'}">
			<div class="content">
				<span translate>KingOrGovernor.Decision.Title</span>
			</div>
		</h6>

		<strong translate options="{{role}}">KingOrGovernor.Decision.Title_?</strong>
		<div translate options="{{role}}">KingOrGovernor.Decision.Text_?</div>

		<div class="buttonFooter">
			<button clickable="acceptRole();">
				<span translate options="{{role}}">KingOrGovernor.Decision.Accept_?</span>
			</button>

			<button class="cancel" clickable="closeOverlay();">
				<span translate options="{{role}}">KingOrGovernor.Decision.Decline_?</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/logout/logout.html"><div class="logout" ng-controller="logoutCtrl">
	<div class="description" translate>
		Logout.TutorialWarning
	</div>
	<div class="buttonFooter">
		<button class="cancel" clickable="closeWindow('logout')">
			<span translate>Button.Cancel</span>
		</button>
		<button class="danger" clickable="logout();">
			<span translate>Button.GoToLobby</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/acpReport.html"><!-- container for modal windows -->
<window ng-repeat="w in windows track by $id(w)" class="modalWrapper" ng-class="w.name"></window>
<div id="modalWindowBlocker"></div></script>
<script type="text/ng-template" id="tpl/mainlayout/buildingQueue.html"><div ng-controller="buildingQueueCtrl" class="centerArea unselectable">
	<div class="buildingQueueContainer queueContainer buildingQueueDragOut">
		<div class="constructionContainer">
			<div ng-repeat="queueType in [BuildingQueue.TYPE_VILLAGE, BuildingQueue.TYPE_RESOURCES]"
				 ng-if="buildingQueue.data.queues[queueType].length > 0 || player.data.tribeId == ROMAN
				 		|| (player.data.tribeId != ROMAN && queueType == BuildingQueue.TYPE_VILLAGE && buildingQueue.data.queues[BuildingQueue.TYPE_RESOURCES].length == 0)"
				 class="buildingQueueSlot entityBox noActive"
				 ng-class="{largeSlot: player.data.tribeId != ROMAN, hover: slotDetails.visible && slotDetails.queue == queueType, paid: buildingQueue.data.queues[queueType].length > 0}"
				 on-pointer-over="showDetails(queueType, 0)" on-pointer-out="hideDetails()">
				<i ng-if="player.data.tribeId != ROMAN && buildingQueue.data.queues[queueType].length == 0"
				   class="slotIcon boxIcon builderIcon feature_buildingqueue_slot_combine_medium_flat_black queueType{{::BuildingQueue.TYPE_VILLAGE}} queueType{{::BuildingQueue.TYPE_RESOURCES}}"></i>
				<i ng-if="player.data.tribeId == ROMAN && buildingQueue.data.queues[queueType].length == 0"
				   class="slotIcon boxIcon feature_buildingqueue_slot_{{$index ? 'fields' : 'village'}}_medium_flat_black queueType{{queueType}}"></i>
				<div progressbar ng-if="buildingQueue.data.queues[queueType].length > 0" finish-time="{{buildingQueue.data.queues[queueType][0].finished}}"
							 duration="{{buildingQueue.data.queues[queueType][0].finished - buildingQueue.data.queues[queueType][0].timeStart}}"></div>
			</div>
		</div>
		<div class="masterBuilderContainer">
			<div ng-repeat="slotNr in []|range:1:BuildingQueue.MASTER_BUILDER_SLOTS"
				 class="buildingQueueSlot entityBox slot{{$index+1}} {{dragClass}}"
				 ng-class="{hover: slotDetails.visible && slotDetails.queue == BuildingQueue.MASTER_BUILDER_SLOTS && slotDetails.slot == $index,
				 			paid: buildingQueue.data.queues[BuildingQueue.TYPE_MASTER_BUILDER][slotNr-1]['paid'],
				 			locked: availableMasterBuilderSlots < slotNr,
				 			empty: buildingQueue.data.queues[BuildingQueue.TYPE_MASTER_BUILDER].length < slotNr,
				 			noActive: (availableMasterBuilderSlots < slotNr || buildingQueue.data.queues[BuildingQueue.TYPE_MASTER_BUILDER].length < slotNr)}"
				 on-pointer-over="showDetails(BuildingQueue.TYPE_MASTER_BUILDER, $index)" on-pointer-out="hideDetails()">
				<div ng-if="buildingQueue.data.queues[BuildingQueue.TYPE_MASTER_BUILDER].length < slotNr && availableMasterBuilderSlots >= slotNr">
					<div class="topLeftBorder"></div>
					<div class="bottomRightBorder"></div>
					<i class="slotIcon builderIcon feature_masterbuilder_small_flat_black"></i>
				</div>
				<i ng-if="availableMasterBuilderSlots < slotNr" class="slotIcon lockedState symbol_lock_small_flat_black"></i>
			</div>
		</div>
		<div ng-repeat="(id, data) in slotImages" drop-class="{{data.queueType == BuildingQueue.TYPE_MASTER_BUILDER ? 'buildingQueueDropHover' : 'noDrop'}}" ng-class="{paid: data.paid}"
			 class="buildingSlotImage buildingMini draggable buildingType{{data.buildingType}} tribeId{{player.data.tribeId}} level{{data.level}} queueType{{data.queueType}} slot{{data.slotNr}} {{$parent.dragClass}}"
			 on-pointer-over="showDetails(data.queueType, data.slotNr - 1)" on-pointer-out="hideDetails()"
			 draggable="{{data}}" dropable="shiftMasterBuilder(object, data.slotNr - 1)"
			 drag-out="buildingQueueDragOut" drag-out-distance="46"
			 on-drag-init="data.queueType == BuildingQueue.TYPE_MASTER_BUILDER ? $parent.dragClass=(data.paid ? 'dragPaid':'dragUnpaid'): false"
			 on-drag-stop="dragOut ? cancelBuilding({{id}}) : false; $parent.dragClass=''">
			<i class="dragMarker boxIcon"></i>
			<div class="levelBubble" ng-class="{enoughResources: data.enoughResources}">{{data.level + 1}}</div>
		</div>
	</div>
	<div ng-if="buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION].length > 0" class="destructionQueueContainer queueContainer destructionQueueDragOut">
		<div class="buildingQueueSlot entityBox noActive"
			 on-pointer-over="showDetails(BuildingQueue.TYPE_DESTRUCTION, 0)" on-pointer-out="hideDetails()">
			<div class="buildingSlotImage buildingMini buildingType{{buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].buildingType}} tribeId{{player.data.tribeId}}
						level{{buildingsByLocation[buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].locationId].data.lvl"
				 ng-class="{draggable: !buildingsByLocation[buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].locationId].data.rubble}"
				 draggable="{{!buildingsByLocation[buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].locationId].data.rubble ? true : null}}"
				 drag-out="destructionQueueDragOut" drag-out-distance="46"
				 on-drag-stop="dragOut ? cancelBuilding({{buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].id}}) : false">
				<i ng-if="!buildingsByLocation[buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].locationId].data.rubble" class="dragMarker boxIcon"></i>
				<div class="levelBubble">{{buildingsByLocation[buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].locationId].data.lvl}}</div>
			</div>
			<div progressbar type="negative" finish-time="{{buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].finished}}"
						 duration="{{buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].finished - buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION][0].timeStart}}"></div>
		</div>
	</div>

	<div ng-include src="'tpl/mainlayout/partials/buildingQueueDetails.html'"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/contextMenu.html"><div id="contextMenu" ng-controller="contextMenuCtrl" ng-style="contextStyle" ng-class="contextMenuClass">
    <div class="backgroundRing"></div>
    <div ng-repeat="item in menuItems" class="item {{item.class}} transition">
		<div ng-show="item.class != 'pos0' && item.class != 'pos6'"
			 class="roundButton"
			 ng-class="{disabled: $eval(item.disabled)}"
			 clickable="item.callback()"
			 tooltip
			 tooltip-class="mapContextMenu {{item.class}}"
			 tooltip-translate="{{!!$eval(item.disabled) ? item.translationKeyDisabled : item.translationKey}}"
			 tooltip-url="{{item.tooltipUrl}}"
			 tooltip-placement="{{getTooltipPlacement(item.class)}}">
			<i ng-class="item.iconClass"></i>
		</div>
		<div ng-if="item.class == 'pos0'"
			 class="middleButton"
			 clickable="item.callback()"
			 on-pointer-over="item.hover = true"
			 on-pointer-out="item.hover = false"
			 ng-class="{hover: item.hover}"
			 tooltip tooltip-class="mapContextMenu {{item.class}}" tooltip-translate="{{item.translationKey}}">
			<i class="{{item.iconClass}}"
			   ng-class="{radialMenu_goToVillage_normal_layout: item.type == 'radialMenu_goToVillage_hover_layout' && !item.hover}"></i>
			<i ng-show="item.type == 'radialMenu_goToVillage_hover_layout'"
			   class="radialMenu_goToVillage_arrow_layout"></i>
		</div>
		<div ng-if="item.class == 'pos6'"
			 class="roundButton farmListRoundButton"
			 tooltip
			 tooltip-translate="{{item.translationKeyDisabled}}"
			 tooltip-show="{{!!$eval(item.disabled)}}"
			 ng-class="{disabled: $eval(item.disabled), inFarmList: item.params.inFarmList, activeRoundButton: activeState}"
			 clickable="openFarmListDialog(true)"
			 on-pointer-over="openFarmListDialog()"
			 on-pointer-out="closeFarmListDialog()">
			<i ng-class="item.iconClass" ng-click="$event.stopPropagation()"></i>
			<div class="hoverArea" on-pointer-over="activeState = true; triggerPreselect()" on-pointer-out="activeState = false" ng-click="$event.stopPropagation()"></div>
			<div ng-if="showAddToFarmList" class="farmListContext">
				<div ng-include src="'tpl/farmListAdd/farmListAdd.html'"></div>
			</div>
		</div>
    </div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/debugMenu.html"><div id="debugMenu" ng-controller="debugCtrl" ng-show="loggedIn">
	<div class="headline">
		<div dropdown class="cheatDropdown" data="dropdown1"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/footer.html"><div id="footer">
	<!-- timed notifications -->
	<div ng-include src="'tpl/mainlayout/notificationsTimed.html'" class="unselectable"></div>

	<!-- notifications -->
	<div ng-include src="'tpl/mainlayout/notifications.html'" class="unselectable"></div>

	<!-- help notifications -->
	<div ng-include src="'tpl/mainlayout/notificationsHelp.html'"></div>

	<!-- chat -->
	<div ng-include src="'tpl/chat/chatFooterBar.html'"></div>

	<!-- servertime -->
	<div id="servertime" class="unselectable" ng-controller="serverTimeCtrl">
		<i class="symbol_clock_small_flat_black time"></i>
		<span i18ndt="{{serverTime}}" format="mediumTime" full="true"></span><span ng-if="timeZoneOffset != 0"> ({{timeZoneOffset}})</span>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/header.html"><div class="ornaments"></div>

<div ng-include src="'tpl/mainlayout/quickLinks.html'"></div>
<div ng-include src="'tpl/mainlayout/villageList.html'" class="unselectable"></div>
<div ng-include src="'tpl/mainlayout/sidebarMenu.html'" ng-show="loggedIn && player.data.villages.length != 0"></div>

<div ng-include src="'tpl/mainlayout/topMenu.html'"></div>
<div ng-include class="resourceBarWrapper" src="'tpl/mainlayout/stockBar.html'"></div>

<div ng-include src="'tpl/mainlayout/userArea.html'"></div>
<div ng-include src="'tpl/mainlayout/heroQuickInfo.html'" class="unselectable"></div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/heroQuickInfo.html"><div id="heroQuickInfo" ng-controller="heroQuickInfoCtrl" ng-show="heroQuickInfo != null">
	<div class="heroStats">
		<div class="stat">
			<i class="label unit_health_tiny_flat_black"></i>
			<div progressbar class = "health"
						 perc = "{{hero.data.health}}"
						 tooltip
					 	 tooltip-url="tpl/mainlayout/partials/hero/healthTooltip.html"
						 tooltip-data="health:{{hero.data['health']}},
									   healthRegeneration:{{heroQuickInfo['healthRegeneration']}},
									   alive:{{heroQuickInfo['status']['alive']}},
									   dead:{{heroQuickInfo['status']['dead']}},
									   reviving:{{heroQuickInfo['status']['reviving']}},
									   reviveDuration:{{hero.data['reviveDuration']|HHMMSS}},
									   untilTime:{{hero.data['untilTime']}}"
						 tooltip-placement="before">
			</div>
		</div>

		<div class="stat">
			<i class="label unit_experience_tiny_flat_black"></i>
			<div progressbar class = "xp"
						 perc = "{{heroQuickInfo['xpPerc']}}"
						 tooltip
						 tooltip-url="tpl/mainlayout/partials/hero/xpTooltip.html"
						 tooltip-data="xpAchieved:{{heroQuickInfo['xpAchieved']}},
									   xpNeeded:{{heroQuickInfo['xpNeeded']}}"
						 tooltip-placement="before">
			</div>
		</div>
	</div>

	<div class="heroLinks">
		<a class="directLink adventureLink"
		   clickable="openWindow('hero', {'herotab': 'Adventures'})"
		   tooltip
		   tooltip-placement="below"
		   tooltip-translate="Tab.Adventures">
			<i class="movement_adventure_small_flat_black" ng-class="{disabled: hero.data.adventurePoints <= 0}"></i>
		</a>

		<a class="framedAvatarImage"
		   clickable="openWindow('hero')"
		   tooltip
		   tooltip-placement="below"
		   tooltip-url="tpl/mainlayout/partials/hero/avatarTooltip.html"
		   tooltip-data="
			   alive:{{heroQuickInfo['status']['alive']}},
			   dead:{{heroQuickInfo['status']['dead']}},
			   reviving:{{heroQuickInfo['status']['reviving']}},
			   reviveDuration:{{hero.data['reviveDuration']|HHMMSS}},
			   untilTime:{{hero.data['untilTime']}}">
			<avatar-image player-id="{{playerId}}" dead="{{!heroQuickInfo['status']['alive']}}"></avatar-image>
			<div class="prestigeStars" ng-if="config.balancing.features.prestige">
				<prestige-stars stars="heroQuickInfo['prestigeStars']" size="tiny"></prestige-stars>
			</div>
		</a>
		<div class="prestigeStarsTooltip"
			 tooltip
			 tooltip-translate-switch="{
			 	'Prestige.Stars.Tooltip.Own': {{!!player.data.nextLevelPrestige}},
			 	'Prestige.Stars.Tooltip.Own.Max': {{!player.data.nextLevelPrestige}}
			 }"
			 tooltip-data="prestige:{{player.data.prestige}},nextLevelPrestige:{{player.data.nextLevelPrestige}}"
			 clickable="openWindow('profile', {'playerId': playerId, 'profileTab': 'prestige'})"
			 ng-if="config.balancing.features.prestige"
				></div>
		<a class="directLink attributesLink"
				clickable="openWindow('hero', {herotab: 'Attributes'})"
				tooltip
				tooltip-placement="below"
				tooltip-url="tpl/mainlayout/partials/hero/attributeTooltip.html"
				tooltip-data="freePoints: {{hero.data['freePoints']}}">
			<div translate class="text">HUD.Hero.Level</div>
			<div class="level">{{(hero.data['level'] - hero.data['levelUp'])}}</div>
			<i class="levelStar symbol_star_small_illu" ng-if="hero.data['freePoints'] > 0 || hero.data['levelUp']"></i>
		</a>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/mainContent.html"><!-- header -->
<header id="layoutHeader" ng-controller="layoutHeaderCtrl" ng-show="loggedIn && player.data.villages.length != 0"
		ng-include="'tpl/mainlayout/header.html'" touch-tooltips></header>

<!-- left sidebar -->
<div ng-include src="'tpl/mainlayout/questCurrentTask.html'" ng-show="loggedIn"></div>

<!-- content -->
<div ng-if="loggedIn" class="ingameContentContainer">
	<div ng-include src="'tpl/village.html'" ng-show="page == 'village'" class="mainContentBackground unselectable"></div>
	<div ng-include src="'tpl/resources.html'" ng-show="page == 'resources'" class="mainContentBackground unselectable"></div>
	<div ng-include src="'tpl/map.html'" ng-show="page == 'map'" class="mainContentBackground unselectable"></div>
	<div ng-include src="'tpl/mainlayout/buildingQueue.html'" class="buildingQueue"></div>
</div>

<div ng-include src="'tpl/user/login.html'" ng-if="!loggedIn && page != 'selectTribe'" class="mainContentBackground login"></div>


<!-- container for modal windows -->
<window ng-repeat="w in windows track by $id(w)" class="modalWrapper" ng-class="w.name"></window>
<div id="modalWindowBlocker"></div>

<div ng-controller="notepadCtrl" id="notepads" ng-show="loggedIn">
	<div ng-if="settings.data.notpadsVisible">
		<notepad class="notepad" ng-repeat="n in notepads.data track by $id(n)" ng-style="n.style">
		</notepad>
	</div>
</div>

<!-- right sidebar -->
<div ng-include src="'tpl/mainlayout/troopsOverview.html'" ng-show="loggedIn"></div>

<!-- Flash notifications -->
<div ng-include src="'tpl/mainlayout/notificationsFlash.html'" ng-show="loggedIn && player.data.villages.length != 0"></div>

<!-- footer -->
<div ng-include src="'tpl/mainlayout/footer.html'" ng-show="loggedIn && player.data.villages.length != 0"></div>

<!-- separate modules -->
<div ng-include src="'tpl/mainlayout/contextMenu.html'" ng-show="loggedIn"></div>
<div ng-include src="'tpl/mainlayout/debugMenu.html'" ng-if="config.SERVER_ENV != 'live' &&  loggedIn"></div>


</script>
<script type="text/ng-template" id="tpl/mainlayout/mellon.html"><a style="display: none;" id="mellonUpgradeBtn" href="javascript:void(0)" mellon-url="/instant/upgrade"></a>
<a style="display: none;" id="mellonLoginBtn" href="javascript:void(0)" mellon-url="/authentication/login"></a>
<div id="jqFensterModalLayout" class="jqFensterModal">
	<div class="jqFensterModalContent">
		Loading...
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/notepad.html"><div resizable="resize" min-width="150" min-height="50" clickable="n.setFocus()">
	<div class="actions" ng-show="over && !n.inEditor && !deleteQuestion">
		<div class="dragExtender"></div>
		<div class="action deleteNote" clickable="askDelete()" tooltip tooltip-translate="Notepad.DeleteNote">
			<i class="action_delete_small_flat_black"></i>
		</div>
		<div class="action editNote" clickable="startEdit()" tooltip tooltip-translate="Notepad.EditNote">
			<i class="action_edit_small_flat_black"></i>
		</div>
		<div class="action addNote" clickable="addNew()" tooltip tooltip-translate="Notepad.AddNote">
			<i class="symbol_plus_tiny_flat_black"></i>
		</div>
	</div>
	<div class="actions active" ng-show="n.inEditor">
		<div class="dragExtender"></div>
		<div class="action active cancelNote" clickable="cancel()" tooltip tooltip-translate="Button.Abort">
			<i class="action_cancel_tiny_flat_white"></i>
		</div>
		<div class="action active saveNote" clickable="save()" tooltip tooltip-translate="Button.Save">
			<i class="action_check_small_flat_white"></i>
		</div>
		<div class="action addNote" clickable="addNew()" tooltip tooltip-translate="Notepad.AddNote">
			<i class="symbol_plus_tiny_flat_black"></i>
		</div>
	</div>
	<div class="actions active" ng-show="deleteQuestion">
		<div class="dragExtender"></div>
		<div class="action active cancelNote" clickable="cancel()" tooltip tooltip-translate="Button.Abort">
			<i class="action_cancel_tiny_flat_white"></i>
		</div>
		<div class="action active saveNote" clickable="delete()" tooltip tooltip-translate="Button.Delete">
			<i class="action_check_small_flat_white"></i>
		</div>
		<div class="action addNote" clickable="addNew()" tooltip tooltip-translate="Notepad.AddNote">
			<i class="symbol_plus_tiny_flat_black"></i>
		</div>
	</div>
	<div class="header" ng-class="{edit: n.inEditor}">
		<div class="dragExtender"></div>
		<div class="verticalLine double"></div>
		<div class="verticalLine double"></div>
		<div class="verticalLine double"></div>
		<div class="verticalLine double"></div>
		<div class="verticalLine double"></div>
		<div class="verticalLine double"></div>
	</div>
	<div class="body" scrollable>
		<div class="text" ng-show="!n.inEditor" user-text-parse="n.data.text" parse="decorations;linkings;reports;coordinates" ></div>
		<div ng-show="n.inEditor" bb-code-input ng-model="n.editText"></div>
	</div>
	<div class="body deleteOverlay" ng-show="deleteQuestion">
		<span translate>Notepad.DeleteQuestion</span>
	</div>
	<div class="footer">
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/notifications.html"><div class="notificationsContainer">
	<div id="reportStream" ng-controller="notificationCtrl">
		<a class="mainLayoutMenuButton directionFrom withArrowTip reportButton"
			clickable="openWindow('reports')"
			tooltip
			tooltip-translate="Button.Reports"
			tooltip-placement="above">
			<i class="feature_report_medium_flat_black"></i>
			<div class="arrow"></div>
		</a>

		<a class="mainLayoutMenuButton directionFrom withArrowTip clearNotifications"
		   tooltip
		   tooltip-translate="Notification.DeleteAll"
		   tooltip-placement="above"
		   clickable="deleteAllNotifications()"
		   ng-if="notifications.data.length > 0"
		   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false">
			<i ng-class="{action_cancel_tiny_flat_black: !cancelHover, action_cancel_tiny_flat_red: cancelHover}"></i>
			<div class="arrowEnding"></div>
		</a>

		<a ng-repeat="n in notifications.data | filter:notificationsFilter | orderBy:'data.time':true"
		   class="notification clickable"
		   tooltip
		   tooltip-translate="Notification_{{n.data.type}}"
		   tooltip-placement="above"
		   clickable="openNotification({{n.data.type}})"
		   play-on-click="{{UISound.OPEN_REPORT}}">
			<i class="{{n.data.icon}}"></i>

			<div ng-if="n.data.count > 1 && n.data.count <= countLimit" class="notificationCount">{{n.data.count}}</div>
			<div ng-if="n.data.count > countLimit" class="notificationCount" translate data="limit: {{countLimit}}">HUD.ExeededLimit</div>

			<i class="closeNotification"
			   ng-class="{action_cancel_tiny_flat_black: !closeHover, action_cancel_tiny_flat_red: closeHover}"
			   on-pointer-over="closeHover = true" on-pointer-out="closeHover = false"
			   tooltip tooltip-translate="Notification.Delete"
			   clickable="n.deleted = {{currentServerTime}}; deleteNotification({{n.data.type}})">
			</i>
		</a>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/notificationsFlash.html"><div ng-controller="notificationFlashCtrl">
	<div id="flashNotifications">
		<div ng-repeat="noty in notifications" class="notification {{noty.type}}" ng-class="noty.class" ng-if="noty.type != 'error' && noty.type != 'chatNotification'">
			<span ng-if="noty.count > 1" clickable="close(noty);" translate data="count:{{noty.count}},text:{{noty.text}}">Notification.Multiple</span>
			<span ng-if="noty.count == 1" clickable="close(noty);">{{noty.text}}</span>
		</div>
		<div ng-repeat="chat in chatNotifications" class="notification  chatNotification" ng-class="chat.class" ng-if="chat.type == 'chatNotification'">
		<span on-pointer-over="chatNotificationOver(chat)" on-pointer-out="chatNotificationOut(chat)"
			  clickable="openConversation(chat.roomId); closeChatNotification(chat);">
		<div class="firstLine">
			<div class="avatar">
				<avatar-image scale="0.5" player-id="{{::chat.playerId}}" avatar-class="profile" ng-if="::chat.playerId > 0"></avatar-image>
				<i  class="kingdomRole community_governor_small_flat_black" ng-if="chat.kingdomRole == kingdomRole.governor"></i>
				<i  class="kingdomRole community_duke_small_flat_black"  ng-if="chat.kingdomRole == kingdomRole.duke"></i>
				<i  class="kingdomRole community_king_small_flat_black"  ng-if="chat.kingdomRole == kingdomRole.king"></i>
			</div>
			<div class="verticalLine"></div>
			<div class="playerInfos">
				<div>
					{{chat.playerName}}
				</div>
				<div>
					<alliance-link class="allianceName" allianceId="{{chat.allianceId}}"
								   allianceName="{{chat.allianceName}}" noLink="true"></alliance-link>
				</div>
			</div>

		</div>
		<div class="horizontalLine"></div>
		<div>
			<div class="message truncated ">{{chat.text}}</div>
			<i class="symbol_arrowTo_tiny_illu messageEndIcon"></i>
		</div>
		</span>
		</div>

	</div>

	<div ng-repeat="warning in notifications" class="notificationWarning fullScreenOverlay" ng-class="warning.class" ng-if="warning.type == 'error'">
		<table class="transparent">
			<tr>
				<td>
					<div class="notification {{warning.type}}">
						<div>
							<div class="errorTitle">
								<i class="symbol_warning_large_flat_red"></i>
								<span translate>Error.GenericErrorTitle</span>
								<i class="closeWarning"
								   ng-class="{action_cancel_small_flat_black: !closeHover, action_cancel_small_flat_green: closeHover}"
								   on-pointer-over="closeHover = true" on-pointer-out="closeHover = false" clickable="close(warning);"></i>
							</div>
							<div class="errorDescription">
								<p>{{warning.text}}</p>

								<p translate>Error.GenericErrorSolution</p>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/notificationsHelp.html"><!-- notifications -->
<div ng-controller="notificationHelpCtrl">
	<div id="helpNotifications" ng-if="!settings.data.disableHelpNotifications" class="positionStart"   ng-class="{show: helpTopic != null}">
		<div class="dialogActor" clickable="openHelpNotification()">
			<div class="tooltip textBubble before" ng-class="{show: helpTopic != null}">
				<div class="tooltipContent">
					<span translate>HelpNotification.TextBubble.Content</span><br>
					<a translate options="{{helpTopic}}">InGameHelp.?.Headline</a>
				</div>
			</div>
			<div class="dialogActorPortrait">
				<img ng-src="layout/images/x.gif" class="characters_helpNotification" />
			</div>
		</div>
		<i class="closeNotification"
		   ng-class="{action_cancel_tiny_flat_black: !closeHover, action_cancel_tiny_flat_red: closeHover}"
		   on-pointer-over="closeHover = true" on-pointer-out="closeHover = false"
		   tooltip tooltip-translate="Notification.Delete"
		   clickable="closeHelpNotification()">
		</i>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/notificationsTimed.html"><div id="timedNotifications" ng-controller="notificationTimedCtrl">
	<a clickable="openActivation();"
	   class="notification activation"
	   ng-if="!player.data.isActivated"
	   tooltip
	   tooltip-translate="Notification.NotActivated"
	   tooltip-placement="above">
		<i class="{{activationIcon}}"></i>
	</a>
	<a ng-repeat="n in notifications.data | orderBy:'data.time':true"
	   class="notification"
	   ng-class="{disabled: !isClickable(n.data.type)}"
	   clickable="openNotification({{n.data.type}})"
	   tooltip
	   tooltip-translate="Notification_{{n.data.type}}"
	   tooltip-data="expireTime:{{n.data.expireTime}}"
	   tooltip-placement="above"
	   ng-if="n.data.time < currentServerTime && (n.data.expireTime == 0 || n.data.expireTime > currentServerTime)">
		<i class="{{n.data.icon}}"></i>
		<div class="timeLeft" ng-if="n.data.expireTime > 0" countdown="{{n.data.expireTime}}" show-days-limit="172800"></div>
	</a>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/questCurrentTask.html"><div class="questCurrentTask" ng-if="activeQuest != null">
	<div class="background">
		<div class="headerBackgroundDecoration start"></div>
		<div class="headerBackgroundDecoration end"></div>
		<div class="content">
			<div class="header">
				<div class="inner" translate options="{{activeQuest.data.id}}">QuestHeader_?</div>
				<div class="smallArrow"></div>
				<div class="doneMarker tutorial_circle_illustration" ng-class="{visible: activeQuest.data.status >= 4}">
					<div class="checkMark tutorial_check_illustration"></div>
				</div>
			</div>
			<div class="subquests" ng-if="activeQuest.data.cfg.subSteps">
				<div ng-repeat="step in activeQuest.data.cfg.subSteps"
					 class="subquest"
					 ng-class="{inactive: activeQuest.data.progress < activeQuest.data.cfg.subSteps[$index-1].progress}">
					<i class="action_check_medium_flat_orange"
					   ng-if="activeQuest.data.progress >= step.progress"></i>
					<div class="currentStep"
						 ng-if="activeQuest.data.progress < step.progress && ($index == 0 || activeQuest.data.progress >= activeQuest.data.cfg.subSteps[$index-1].progress)">
					</div>
					<i class="action_check_medium_flat_black"
					   ng-class="{disabled: activeQuest.data.progress < activeQuest.data.cfg.subSteps[$index-1].progress}"
					   ng-if="activeQuest.data.progress < activeQuest.data.cfg.subSteps[$index-1].progress"></i>
					<span class="inner" translate options="{{step.key}}">QuestStep_?</span>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/queueOverview.html"><!-- Currently only in mobile view used --></script>
<script type="text/ng-template" id="tpl/mainlayout/quickLinks.html"><div id="quickLinks" class="headerButton">
	<building-quicklinks show-all></building-quicklinks>
	<div class="arrow"></div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/sidebarMenu.html"><div id="sidebarMenu" class="sidebar unselectable" ng-controller="sidebarMenuCtrl">
	<div class="communitiesButtonWrapper"
		 id="jsQuestButtonCommunities">
		<div class="mainLayoutMenuButton directionDown communitiesButton"
			 clickable="openWindow('society')"
			 tooltip
			 tooltip-translate="SideMenu.Kingdom.Header"
			 tooltip-placement="after">
			<i class="sideMenu_communities_medium_illu"></i>
		</div>
	</div>

	<div class="treasureCount"
		 id="jsQuestTreasureCount"
		 ng-if="player.data.kingdomId > 0"
		 tooltip
		 tooltip-url="tpl/mainlayout/partials/treasureTooltip.html"
		 tooltip-placement="after">
		<div class="backgroundStart sideMenu_treasureBackgroundStart_layout"></div>
		<div class="content">
			<i class="unit_treasure_small_flat_black"></i>
			{{treasures.data.treasuresCurrent|bidiNumber:'':false:false:false:true}}
		</div>
		<div class="backgroundEnd sideMenu_treasureBackgroundEnd_layout"></div>
	</div>

	<div class="mainLayoutMenuButton directionDown withArrowTip communityAttacksButton"
		 id="jsQuestButtonCommunityAttacks"
		 clickable="openWindow('society', {tab:'Attacks'})"
		 tooltip
		 tooltip-translate="Button.AttacksKingdomAlliance"
		 tooltip-placement="after">
		<div class="arrowEnding"></div>
		<i class="sideMenu_communityAttacks_small_flat_black"></i>
		<div ng-if="attacksCounter != 0 && attacksCounter <= attackLimit" class="notificationCount">{{attacksCounter}}</div>
		<div ng-if="attacksCounter > attackLimit" class="notificationCount" translate data="limit: {{attackLimit}}">HUD.ExeededLimit</div>
	</div>

	<div class="mainLayoutMenuButton directionDown withArrowTip"
		 id="jsQuestButtonQuestbook"
		 clickable="openWindow('questBook', {'npcId': 0})"
		 tooltip
		 tooltip-translate="Quest.QuestBook"
		 tooltip-placement="after"
		 play-on-click="{{UISound.OPEN_REPORT}}">
		<div class="arrowEnding"></div>
		<i class="sideMenu_questBook_small_flat_black"></i>
		<div ng-if="questBookCount > 0" class="notificationCount">{{questBookCount}}</div>
	</div>

	<div class="mainLayoutMenuButton directionDown withArrowTip"
		 id="jsQuestButtonStatistics"
		 clickable="openWindow('statistics')"
		 tooltip
		 tooltip-translate="Button.Statistics"
		 tooltip-placement="after">
		<div class="arrowEnding"></div>
		<i class="sideMenu_statistics_small_flat_black"></i>
	</div>

	<div class="mainLayoutMenuButton directionDown withArrowTip"
		 ng-class="{highlighted : chat.hasUnreadEntries, showAnimation: animateIgm}"
		 id="jsQuestButtonIgm"
		 clickable="openWindow('igm')"
		 tooltip
		 tooltip-translate="Button.Igm"
		 tooltip-placement="after"
		 play-on-click="{{UISound.OPEN_REPORT}}">
		<div class="arrowEnding"></div>
		<i class="sideMenu_igm_small_flat_black"></i>
		<div ng-if="chat.newIGMs > 0" class="notificationCount">{{chat.newIGMs}}</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/stockBar.html"><div id="resourceBar" ng-controller="resourcesCtrl">
	<div class="background" ng-class="{worldEnded: serverStatus == 'worldEnded'}"></div>
	<div ng-if="serverStatus != 'worldEnded'">
		<div ng-repeat="n in []|range:1:4" clickable="openWindow('productionOverview', {'tab' : '{{::resNames[n][0].toUpperCase()+resNames[n].slice(1)}}'});">
			<div class="stockContainer {{resNames[n]}}">
				<div tooltip tooltip-url="tpl/mainlayout/partials/resourceTooltip.html">
					<div progressbar label-icon="unit_{{::resNames[n]}}_medium_illu resType{{::n}}"
								 gain-animation-icon="animation_{{::resNames[n]}}_large_illu"
								 value="{{tmpResources[n] === 0 ? 0 : tmpResources[n] || village.data.calculatedStorage[n]}}"
								 max-value="{{village.data.storageCapacity[n]}}"
								 value-interpolation="{{interpolateResources}}"
								 interpolation-threshold="{{interpolationThresholds[n]}}"
								 type="{{village.data.production[n] < 0 ? 'negative withTransition' : 'withTransition'}}"></div>
				</div>
				<div class="production">
					<div class="value">
						{{(village.data.production[n] >= 0 ? '+' : '') + village.data.production[n]}}
					</div>
				</div>
			</div>
			<div class="divider" ng-if="::!$last"></div>
		</div>
	</div>

	<div ng-if="serverStatus == 'worldEnded'" clickable="openWindow('worldEnded')"
		 class="stockContainer worldEnd" ng-controller="worldEndedSummaryCtrl">
		<h2 translate>WorldEnded.Summary</h2>
		(<span i18ndt="{{endTime}}" format="short"></span>)
		<div class="winnerWrapper headerTrapezoidal">
			<div class="content">
				<div class="wrapper">
					<div class="wrapper2">
						<i class="winnerAlliance"></i>
						<span translate data="allianceId:{{winnerAllianceId}}, allianceName:{{winnerAllianceTag}}">WorldEnded.WinnerAlliance</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/topMenu.html"><div id="topMenu">

	<nav id="mainNavigation">
		<a clickable="setPage('{{button}}')"
		   tooltip
		   tooltip-translate="Navi_{{button}}"
		   ng-repeat="button in buttons"
		   class="navi_{{button}} bubbleButton"
		   on-pointer-over="jumpToActiveVillageHover = true"
		   on-pointer-out="jumpToActiveVillageHover = false"
		   id="optimizly_mainnav_{{button}}"
		   ng-class="{active: activeButton == button, hovered: !villageCentered && activeButton == button && button == 'map'}">
			<i id="mainNaviIcon{{button}}" class="header_{{button}}_large_illu"></i>
			<i ng-class="{jumpToActiveVillage_small_flat_black: !jumpToActiveVillageHover, jumpToActiveVillage_small_flat_green: jumpToActiveVillageHover}"
			   class="jumpToActiveVillage"
			   ng-if="!villageCentered && activeButton == button && button == 'map'"></i>
		</a>
	</nav>

	<div id="subNavigation">

		<a class="troop subButton"
		   clickable="openWindow('building', {'location': Building.RALLY_POINT_LOCATION})"
		   ng-controller="populationCtrl"
		   tooltip
		   tooltip-translate="CropConsumptionTroops">
			<i class="unit_troop_medium_illu"></i>
			<div class="value">
				{{cropConsumption}}
			</div>
		</a>

		<a class="population subButton"
		   clickable="openWindow('productionOverview', {tab: 'Balance'});"
		   ng-controller="populationCtrl"
		   tooltip
		   tooltip-translate="Population">
			<i class="unit_population_medium_illu"></i>
			<div class="value">
				{{population}}
			</div>
		</a>

		<a ng-if="!goldActive"
			class="gold subButton noClick deactivated"
		   tooltip
		   tooltip-translate="Sitter.NotEnoughRightsTooltip">
			<i class="unit_gold_medium_illu"></i>
			<div class="value">
				-
			</div>
		</a>

		<a ng-if="goldActive"
			class="gold subButton"
		   clickable="openWindow('payment',{});"
		   tooltip
		   tooltip-translate="SubNavi.Premium">
			<i class="unit_gold_medium_illu"></i>
			<div animated-counter value="gold" duration="1000" event-to-trigger="goldAmountChanged" animation-class="counterChange" class="value">
				{{gold}}
			</div>
		</a>

		<a class="silver subButton"
		   tooltip
		   tooltip-translate="SubNavi.Auctions"
		   clickable="openWindow('hero', { herotab: 'Auctions' });">
			<i class="unit_silver_medium_illu"></i>
			<div animated-counter value="silver" duration="1000" event-to-trigger="silverAmountChanged" animation-class="counterChange" class="value">
				{{silver}}
			</div>
		</a>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/troopsOverview.html"><div class="troopsOverview" scrollable troops-overview-height>
	<div id="troopMovements" ng-controller="troopMovementsCtrl" ng-show="loggedIn">
		<ul ng-show="troopMovements.length > 0" class="troopMovements">
			<li ng-repeat="movementGroup in troopMovements"
				class="{{movementGroup['name']}} {{movementGroup['movementDirection']}}"
				ng-class="{alertBlink: movementGroup['name'] == 'incoming_attacks' && movementGroup[0]['data']['movement']['timeFinish'] < currentServerTime+60}"
				tooltip
				tooltip-placement="before"
				tooltip-url="{{movementGroup['tooltipTemplate']}}"
				clickable="openRallypoint(movementGroup['movementDirection'])">
				<i ng-class="movementGroup['movementIcon']"></i>

				<div class="countdown" countdown="{{movementGroup[0]['data']['movement']['timeFinish']}}"></div>
				<div ng-if="movementGroup.length <= troopMovementLimit" class="count">{{movementGroup.length}}</div>
				<div ng-if="movementGroup.length > troopMovementLimit" class="count" translate data="limit: {{troopMovementLimit}}">HUD.ExeededLimit</div>
				<div class="ending">
					<div class="colored"></div>
				</div>
			</li>
		</ul>
	</div>

	<div id="troopsStationed" ng-controller="troopsStationedCtrl" ng-show="loggedIn">
		<ul ng-show="troopsStationed.length > 0" class="troopsStationed">
			<ul ng-repeat="group in troopsStationed track by $index"
				ng-show="group['sum'] > 0"
				ng-init="groupId = $index">

				<li class="tribe"
					ng-class="{active: groupsStatus[groupId]}"
					clickable="openGroup(groupId)"
					tooltip
					tooltip-placement="before"
					tooltip-translate="Tribe_{{group['tribeId']}}">
					<i class="tribe tribe_{{group['tribe']}}_large_illu"></i>

					<div class="count">{{group['sum']}}</div>
				</li>

				<li ng-repeat="unit in group['units'] track by $index"
					ng-show="groupsStatus[groupId] && unit['sum'] > 0"
					ng-init="unitId = $index"
					clickable="openWindow('building', {'location': 32});"
					tooltip
					tooltip-placement="before"
					tooltip-url="tpl/mainlayout/partials/troopTypeTooltip.html"
					class="unit">
					<span unit-icon class="unitIcon" data="group['tribeId'], unitId"></span>
					<div class="count">{{unit['sum']}}</div>
				</li>
			</ul>
		</ul>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/unitQueue.html"><!-- Currently only in mobile view used --></script>
<script type="text/ng-template" id="tpl/mainlayout/unitQueueTooltip.html"><!-- Currently only in mobile view used --></script>
<script type="text/ng-template" id="tpl/mainlayout/userArea.html"><div id="userArea" ng-controller="userAreaCtrl" ng-if="loggedIn">
	<a id="logoutButton"
	   class="headerButton"
	   clickable="doLogout()"
	   tooltip
	   tooltip-class="userAreaTooltip"
	   tooltip-translate="Button.GoToLobby">
		<i class="userArea_logout_small_flat_white"></i>
		<div class="arrow"></div>
	</a>

	 <a id="sitterButton"
		ng-if="isSitter"
		class="headerButton"
		tooltip
		tooltip-class="userAreaTooltip"
		tooltip-url="tpl/user/sitterRightsTooltip.html">
		 <i class="userArea_sitter_small_flat_white"></i>
		 <div class="arrow"></div>
	 </a>

	<a id="userNameButton"
	   class="headerButton"
	   clickable="openWindow('profile', {'playerId': player.data.playerId, 'profileTab': 'playerProfile'})"
	   tooltip
	   tooltip-class="userAreaTooltip"
	   tooltip-translate="Button.OwnProfile">
		<span class="text">{{player.data.name}}</span>
		<div class="arrow"></div>
	</a>

	<a id="settingsButton"
	   class="headerButton"
	   clickable="openWindow('profile', {'playerId': player.data.playerId, 'profileTab': 'settings'})"
	   tooltip
	   tooltip-class="userAreaTooltip"
	   tooltip-translate="Button.Settings">
		<i class="userArea_settings_small_flat_white"></i>
		<div class="arrow"></div>
	</a>

	<a id="helpButton"
	   class="headerButton"
	   clickable="openWindow('help')"
	   tooltip tooltip-translate="Button.HelpCenter">
		<i class="symbol_questionMark_small_flat_white"></i>
		<div class="arrow"></div>
	</a>

	<a id="soundButton"
	   class="headerButton"
	   tooltip
	   tooltip-class="userAreaTooltip"
	   tooltip-translate-switch="{
			'Settings.Audio.MainTabEnable': {{!!muted}},
			'Settings.Audio.MainTabDisable': {{!muted}}
		}">
		<div class="headerButtonWrapper"
			 on-pointer-over="soundHover = true;" on-pointer-out="soundHover = false; soundClick = false;"
			 clickable="muteSound(); soundClick = true;">
			 <i ng-class="{
					userArea_soundOff_small_flat_white: (muted && (!soundHover || soundClick)) || (!muted && soundHover && !soundClick),
					userArea_soundOn_small_flat_white: (!muted && (!soundHover || soundClick)) || (muted && soundHover && !soundClick)
				}"></i>
			<div class="arrow"></div>
		</div>
	</a>

	<a id="notepadButton"
	   class="headerButton"
	   clickable="toggleNotepads()"
	   tooltip tooltip-translate="Notepad.Toggle">
		<i class="userArea_notepad_small_flat_white"></i>
		<div class="arrow"></div>
	</a>

	<a id="forumButton"
	   class="headerButton"
	   clickable="openForum();"
	   tooltip
	   tooltip-class="userAreaTooltip"
	   tooltip-translate="Button.Forum">
		<span class="text" translate>HelpMenu.Forum</span>
		<i class="userArea_forum_small_flat_white"></i>
		<div class="arrow"></div>
	</a>

	<a id="wikiButton"
	   class="headerButton"
	   clickable="openWiki();">
		<span class="text" translate>HelpMenu.Wiki</span>
		<i class="userArea_wiki_small_flat_white"></i>
		<div class="arrow"></div>
	</a>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/villageList.html"><div ng-controller="villageListCtrl" id="villageList" ng-class="{ongoingAttack: ongoingAttack}" ng-show="loggedIn">
	<div class="start"></div>

	<div class="currentVillageName dropdown">

		<a clickable="previousVillage()" class="navigation previous">
			<div class="button">
				<i class="symbol_arrowFrom_tiny_flat_black"></i>
			</div>
		</a>

		<div dropdown data="dropdown" logged-in="loggedIn">
			<div class="villageEntry" ng-class="{attack: option.underAttack}">{{option.name}}</div>
			<i ng-show="option.underAttack" class="movement_attack_small_flat_red"></i>

			<div class="acceptance" ng-show="option.acceptance < 100"><span translate>HUD.Villagelist.Acceptance</span>: {{option.acceptance}}</div>
		</div>

		<a clickable="nextVillage()" class="navigation next">
			<div class="button">
				<i class="symbol_arrowTo_tiny_flat_black"></i>
			</div>
		</a>

		<a id="villageOverview"
		   class="iconButton"
		   clickable="openWindow('villagesOverview');"
		   tooltip
		   tooltip-placement="below"
		   tooltip-translate="Title.VillagesOverview">

			<i class="villageList_villageOverview_small_flat_black"></i>
	    </a>
	</div>

	<div class="end"></div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/modals/chat.html"><div class="modal {{w.params.modalParams.additionalClass}} chatModal minWidth"
	 resizable="resizeWindow" init-width="350" init-height="300" min-width="350" max-width="350" min-height="200" data-padding="10"
	 ng-model="w">
	<div class="modalContent">
		%REPLACE_WITH_INNER_TEMPLATE%
	</div>
</div>

</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/default.html"><div class="modal {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}"
	 ng-class="{inWindowPopupOpened: inWindowPopupOpened}"
	 ng-controller="windowCtrl">
	<div class="modalContent" ng-style="{minHeight: (w.getOverlayHeightWithPadding() || 'none'), height: (w.setToMaxSize ? w.maxWindowBodySizeObj.max+'px' : 'auto')}"
		 ng-class="{inWindowPopupOpened: inWindowPopupOpened}">
	<div class="modalDecoration"></div>

		<div class="functionPanel unselectable">
			<a ng-if="w.params.modalParams.closeable"
			   clickable="closeWindow('{{windowName}}')"
			   class="closeWindow"
			   play-on-click="{{UISound.BUTTON_CLOSE}}">
				<div class="decoration" tooltip tooltip-translate="Button.Close">
					<i class="action_cancel_tiny_flat_black"></i>
				</div>
			</a>
		</div>

		<div ng-include ng-if="w.contentHeaderTemplate" src="w.contentHeaderTemplate" class="unselectable"></div>
		<div class="contentHeader unselectable" ng-if="!w.contentHeaderTemplate">
			<h2>
				<span translate options="{{w.windowName}}">?</span>
			</h2>
		</div>

		<div tabulation class="contentTabulation">
			%REPLACE_WITH_INNER_TEMPLATE%
		</div>

		<window-overlay></window-overlay>

	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/modern.html"><div class="notificationWarning modal {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-class="{inWindowPopupOpened: inWindowPopupOpened}" ng-controller="windowCtrl">
	<table class="transparent">
		<tr>
			<td>
				<div class="notification error">
					<div>
						<div class="errorTitle">
							<i class="symbol_warning_large_flat_red"></i>
							<span translate options="{{w.windowName}}" data="{{w.windowNameData}}">?</span>
							<i ng-if="w.params.modalParams.closeable" class="closeWarning"
							   ng-class="{action_cancel_small_flat_black: !closeHover, action_cancel_small_flat_green: closeHover}"
							   on-pointer-over="closeHover = true" on-pointer-out="closeHover = false" clickable="closeWindow('{{windowName}}')"></i>
						</div>
						<div class="errorDescription">
							%REPLACE_WITH_INNER_TEMPLATE%
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/modernWithOverlay.html"><div class="notificationWarning modal {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-class="{inWindowPopupOpened: inWindowPopupOpened}" ng-controller="windowCtrl">
	<div class="modalContent" ng-style="{minHeight: (w.getOverlayHeightWithPadding() || 'none'), height: (w.setToMaxSize ? w.maxWindowBodySizeObj.max+'px' : 'auto')}"
		 ng-class="{inWindowPopupOpened: inWindowPopupOpened}">
		<div class="notification error">
			<div>
				<div class="errorTitle">
					<i class="symbol_warning_large_flat_red"></i>
					<span translate options="{{w.windowName}}" data="{{w.windowNameData}}">?</span>
					<i ng-if="w.params.modalParams.closeable" class="closeWarning"
					   ng-class="{action_cancel_small_flat_black: !closeHover, action_cancel_small_flat_green: closeHover}"
					   on-pointer-over="closeHover = true" on-pointer-out="closeHover = false" clickable="closeWindow('{{windowName}}')"></i>
				</div>
				<div class="errorDescription">
					%REPLACE_WITH_INNER_TEMPLATE%
				</div>
			</div>
		</div>
		<window-overlay></window-overlay>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/noLayout.html">%REPLACE_WITH_INNER_TEMPLATE%
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/noTabulation.html"><div class="modal {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-class="{inWindowPopupOpened: inWindowPopupOpened}" ng-controller="windowCtrl">
	<div class="modalContent" >
		<div class="modalDecoration"></div>

		<div class="functionPanel">
			<a ng-if="w.params.modalParams.closeable"
			   clickable="closeWindow('{{windowName}}')"
			   class="closeWindow"
			   play-on-click="{{UISound.BUTTON_CLOSE}}">
			<div class="decoration" tooltip tooltip-translate="Button.Close">
					<i class="action_cancel_tiny_flat_black"></i>
				</div>
			</a>
		</div>

        <div ng-include ng-if="w.contentHeaderTemplate" src="w.contentHeaderTemplate"></div>
        <div class="contentHeader" ng-if="!w.contentHeaderTemplate">
            <h2><span translate options="{{w.windowName}}">?</span></h2>
        </div>

		%REPLACE_WITH_INNER_TEMPLATE%

		<div ng-show="inWindowPopupOpened" class="inWindowPopupWrapper">
			<div class="darkener" clickable="closeOverlay();" play-on-click="{{UISound.BUTTON_CLOSE}}"></div>
			<div class="inWindowPopup {{popupClass}}">
				<div class="inWindowPopupHeader">
					<h4 translate options="{{popupTitle}}">?</h4>
					<a class="closeInWindowPopup" clickable="closeOverlay();" play-on-click="{{UISound.BUTTON_CLOSE}}" translate>Button.Close</a>
				</div>
				<div class="inWindowPopupContent">
					<div ng-include src="popupTpl"></div>
				</div>
			</div>
		</div>

	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/simple.html"><div class="modal simple {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-controller="windowCtrl">
	<div class="modalContent">
		%REPLACE_WITH_INNER_TEMPLATE%
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/small.html"><div class="modal small {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-class="{inWindowPopupOpened: inWindowPopupOpened}" ng-controller="windowCtrl">
	<div class="modalContent" ng-style="{minHeight: w.getOverlayHeightWithPadding(-10) || 'none'}">
		<div class="functionPanel">
			<a ng-if="w.params.modalParams.closeable"
			   clickable="closeWindow('{{windowName}}')"
			   class="closeWindow"
			   play-on-click="{{UISound.BUTTON_CLOSE}}">
				<i class="closeWindow"
				   ng-class="{action_cancel_small_flat_black: !cancelHover, action_cancel_small_flat_green: cancelHover}"
				   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"></i>
			</a>
		</div>

		<div class="contentHeader">
			<h2 ng-if="!w.contentHeaderText">
				<span translate options="{{w.windowName}}" data="{{w.windowNameData}}">?</span>
			</h2>
			<h2 ng-if="w.contentHeaderText">{{w.contentHeaderText}}</h2>
		</div>

		%REPLACE_WITH_INNER_TEMPLATE%

		<window-overlay name="smallOverlay"></window-overlay>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/smallNoOverlay.html"><div class="modal small {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-class="{inWindowPopupOpened: inWindowPopupOpened}" ng-controller="windowCtrl">
	<div class="modalContent" ng-style="{minHeight: w.getOverlayHeightWithPadding(-10) || 'none'}">
		<div class="functionPanel">
			<a ng-if="w.params.modalParams.closeable"
			   clickable="closeWindow('{{windowName}}')"
			   class="closeWindow"
			   play-on-click="{{UISound.BUTTON_CLOSE}}">
				<i class="closeWindow"
				   ng-class="{action_cancel_small_flat_black: !cancelHover, action_cancel_small_flat_green: cancelHover}"
				   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"></i>
			</a>
		</div>

		<div class="contentHeader">
			<h2 ng-if="!w.contentHeaderText">
				<span translate options="{{w.windowName}}" data="{{w.windowNameData}}">?</span>
			</h2>
			<h2 ng-if="w.contentHeaderText">{{w.contentHeaderText}}</h2>
		</div>

		%REPLACE_WITH_INNER_TEMPLATE%
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/worldEnd.html"><div class="modal worldEnd {{w.params.modalParams.additionalClass}} {{w.params.modalParams.windowName}} {{windowClass}}" ng-controller="windowCtrl">
	<div class="modalContent" ng-style="{minHeight: w.getOverlayHeightWithPadding(-10) || 'none'}">
		<div class="endOfWorldDecoration contentHeader">
			<h2>
				<span translate options="{{w.windowName}}" data="{{w.windowNameData}}">?</span>
			</h2>
		</div>
		<div class="functionPanel">
			<a ng-if="w.params.modalParams.closeable"
			   clickable="closeWindow('{{windowName}}')"
			   class="closeWindow">
				<i class="action_cancel_small_flat_black"></i>
			</a>
		</div>
		<div tabulation class="contentTabulation">
			%REPLACE_WITH_INNER_TEMPLATE%
		</div>

		<window-overlay></window-overlay>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/modals/partials/inWindowPopup.html"><div class="inWindowPopup"
	 ng-class="{warning: overlayConfig['isAWarning']}">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}" ng-if="overlayConfig['inWindowPopupTitle'] != ''">?</h4>
		<h4 ng-if="overlayConfig['inWindowPopupTitleText'] != ''">{{overlayConfig['inWindowPopupTitleText']}}</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div ng-include src="overlayConfig['inWindowPopupContentTemplate']"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/modals/partials/pagination.html"><div ng-transclude></div>
<div class="tg-pagination" ng-show="visible">
	<ul>
		<li class="firstPage" ng-class="{disabled: currentPage == 1}"
			clickable="firstPage()"
			on-pointer-over="beginningHover = true" on-pointer-out="beginningHover = false">
			<i ng-class="{
				action_toBeginning_tiny_flat_black: !beginningHover || (beginningHover && currentPage == 1),
				action_toBeginning_tiny_flat_green: beginningHover && currentPage != 1,
				disabled: currentPage == 1
			}"></i>
		</li>
		<li class="prevPage" ng-class="{disabled: currentPage == 1}"
			clickable="prevPage()"
			on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
			<i ng-class="{
				symbol_arrowFrom_tiny_flat_black: !fromHover || (fromHover && currentPage == 1),
				symbol_arrowFrom_tiny_flat_green: fromHover && currentPage != 1,
				disabled: currentPage == 1
			}"></i>
		</li>
		<li class="number" ng-repeat="pageNumber in filteredPageNumbers track by $index"
			ng-class="{disabled: (currentPage == pageNumber || pageNumber == '...')}"
			clickable="setPage({{pageNumber}})">
			<a ng-class="{disabled: (currentPage == pageNumber || pageNumber == '...')}">{{pageNumber}}</a>
		</li>
		<li class="nextPage" ng-class="{disabled: disableNext()}"
			on-pointer-over="toHover = true" on-pointer-out="toHover = false"
			clickable="nextPage()">
			<i ng-class="{
				symbol_arrowTo_tiny_flat_black: !toHover || (toHover && disableNext()),
				symbol_arrowTo_tiny_flat_green: toHover && !disableNext(),
				disabled: disableNext()
			}"></i>
		</li>
		<li class="lastPage" ng-class="{disabled: disableNext()}"
			on-pointer-over="endHover = true" on-pointer-out="endHover = false"
			clickable="lastPage()">
			<i ng-class="{
				action_toEnd_tiny_flat_black: !endHover || (endHover && disableNext()),
				action_toEnd_tiny_flat_green: endHover && !disableNext(),
				disabled: disableNext()
			}"></i>
		</li>
	</ul>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/modals/partials/tabulation.html"><nav class="tabulation {{tabData.tabName}} {{tabData.tabType}} unselectable" ng-if="tabData.tabs.length > 1">
	<a class="tab" clickable="selectTab('{{tab}}')"
	   ng-repeat="tab in tabData.tabs"
	   id="optimizely_{{tabData.tabType}}_{{tab}}"
	   ng-class="{active: tab == tabData.currentTab, inactive: tab != tabData.currentTab}"
	   play-on-click="{{tabData.soundType}}">
		<div class="content ">
			<span ng-if="!tabData.html[tab]" translate options="Tab.{{tab}}">?</span>
			<span ng-if="tabData.html[tab]" ng-bind-html="tabData.html[tab]"></span>
		</div>
	</a>
</nav>
<div class="tabulationContent" scrolling-disabled="{{tabData.currentDisableScrolling === true}}" scrollable height-dependency="max">
    <div ng-transclude></div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/modals/partials/windowOverlay.html"><div ng-if="overlayController"
	 class="windowOverlay"
	 id="{{overlayConfig['overlayName']}}"
	 ng-controller="overlayController">
	<div class="darkener" clickable="closeOverlay()"></div>
	<div ng-include src="overlayConfig['inWindowPopupTemplate']"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/partials/UIHint.html"><div ui-hint>
	<div class="header">
		<div class="close"
			 clickable="closeUIHint()"
			 on-pointer-over="closeHover = true" on-pointer-out="closeHover = false">
			<i ng-class="{action_cancel_tiny_flat_white: !closeHover, action_cancel_tiny_flat_green: closeHover}"></i>
		</div>
	</div>
	<div class="content">
		%REPLACE_WITH_INNER_TEMPLATE%
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/buildingCancelTooltip.html"><div class="cancelBuildingTooltip">
	<div ng-if="buildingQueue.data.queues[queueType][slotDetails.slot].paid">
		<div ng-if="paidMaxLvlInQueue[slotDetails.building[queueType].data.locationId] > (queueType == BuildingQueue.TYPE_MASTER_BUILDER ? slotDetails.level : slotDetails.building[queueType].data.lvl)"
			 data="type:{{slotDetails.building[queueType].data.buildingType}},lvl:{{(queueType == BuildingQueue.TYPE_MASTER_BUILDER ? slotDetails.level : slotDetails.building[queueType].data.lvl) + 1}}" translate>
			BuildingQueue.Details.Tooltip.CancelHigherLevelFirst</div>
		<div data="type:{{slotDetails.building[queueType].data.buildingType}},lvl:{{Math.max((queueType == BuildingQueue.TYPE_MASTER_BUILDER ? slotDetails.level : slotDetails.building[queueType].data.lvl), paidMaxLvlInQueue[slotDetails.building[queueType].data.locationId]) + 1}}" translate>
			BuildingQueue.Details.Tooltip.CancelResources</div>
		<div class="horizontalLine"></div>
		<display-resources resources="slotDetails.building[queueType].data.nextUpgradeCosts[Math.max((queueType == BuildingQueue.TYPE_MASTER_BUILDER ? slotDetails.level : slotDetails.building[queueType].data.lvl), paidMaxLvlInQueue[slotDetails.building[queueType].data.locationId])]"
						   color-positive="true" check-storage="true" signed="true"></display-resources>
	</div>
	<div ng-if="!buildingQueue.data.queues[queueType][slotDetails.slot].paid && queueType != BuildingQueue.TYPE_DESTRUCTION">
		<div translate>BuildingQueue.Details.Tooltip.CancelUpgrade</div>
	</div>
	<div ng-if="queueType == BuildingQueue.TYPE_DESTRUCTION">
		<div translate>BuildingQueue.Details.Tooltip.CancelDemolish</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/partials/buildingQueueDetails.html"><div ng-if="slotDetails.visible && (slotDetails.queue != BuildingQueue.TYPE_DESTRUCTION || buildingQueue.data.queues[BuildingQueue.TYPE_DESTRUCTION].length > 0)"
	 class="detailsView queueContainer queueType{{slotDetails.queue}} slot{{slotDetails.slot+1}}"
	 ng-class="{usedSlot: buildingQueue.data.queues[slotDetails.queue][slotDetails.slot], lockedSlot: availableMasterBuilderSlots < slotDetails.slot+1}"
	 on-pointer-over="showDetails()" on-pointer-out="hideDetails()">
	<div class="detailsInnerBox">

		<div class="detailsHeader detailsRow">
			<div class="detailsImageContainer">
				<i class="headerIcon" ng-class="{
					feature_buildingQueue_medium_illu: slotDetails.queue == BuildingQueue.TYPE_VILLAGE || slotDetails.queue == BuildingQueue.TYPE_RESOURCES,
					feature_buildingMaster_medium_illu: slotDetails.queue == BuildingQueue.TYPE_MASTER_BUILDER,
					action_dismantle_medium_flat_black: slotDetails.queue == BuildingQueue.TYPE_DESTRUCTION && buildingQueue.data.queues[slotDetails.queue][0].isRubble == 1,
					action_demolish_medium_flat_black: slotDetails.queue == BuildingQueue.TYPE_DESTRUCTION && buildingQueue.data.queues[slotDetails.queue][0].isRubble == 0}"></i>
			</div>
			<div options="{{slotDetails.queue + (slotDetails.queue == BuildingQueue.TYPE_DESTRUCTION && buildingQueue.data.queues[slotDetails.queue][0].isRubble == 1 ? '_Rubble' : '')}}"
				 class="headerText" translate >BuildingQueue.Details.Action_?</div>
		</div>

		<div class="detailsContent detailsRow"
			 ng-repeat="queueType in (player.data.tribeId == ROMAN && (slotDetails.queue == BuildingQueue.TYPE_VILLAGE || slotDetails.queue == BuildingQueue.TYPE_RESOURCES) ? [BuildingQueue.TYPE_VILLAGE, BuildingQueue.TYPE_RESOURCES] : [slotDetails.queue])">
			<div class="detailsImageContainer subContainer">
				<div ng-if="buildingQueue.data.queues[queueType][slotDetails.slot]" tooltip tooltip-url="tpl/mainlayout/partials/buildingQueueTooltip.html"
					 class="buildingSlotImage buildingMini buildingType{{buildingQueue.data.queues[queueType][slotDetails.slot].buildingType}} tribeId{{player.data.tribeId}} level{{buildingsByLocation[buildingQueue.data.queues[queueType][slotDetails.slot].locationId].data.lvl}}"></div>
				<i class="cancelBuilding"
				   ng-if="buildingQueue.data.queues[queueType][slotDetails.slot] && !(buildingQueue.data.queues[slotDetails.queue][0].isRubble == 1)"
				   ng-class="{action_cancel_tiny_flat_black: !cancelHover,
				   			  action_cancel_tiny_flat_red: cancelHover}"
				   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"
				   play-on-click="{{UISound.BUILDING_UPGRADE_CANCEL}}"
				   clickable="cancelBuilding({{buildingQueue.data.queues[queueType][slotDetails.slot].id}})"
				   tooltip tooltip-url="tpl/mainlayout/partials/buildingCancelTooltip.html"
				   tooltip-data="queueType:{{queueType}}"></i>
				<i ng-if="player.data.tribeId != ROMAN && buildingQueue.data.queues[queueType].length == 0 && (queueType == BuildingQueue.TYPE_VILLAGE || queueType == BuildingQueue.TYPE_RESOURCES)"
				   class="queueIcon builderIcon feature_buildingqueue_slot_combine_medium_flat_black"></i>
				<i ng-if="player.data.tribeId == ROMAN && buildingQueue.data.queues[queueType].length == 0 && (queueType == BuildingQueue.TYPE_VILLAGE || queueType == BuildingQueue.TYPE_RESOURCES)"
				   class="queueIcon feature_buildingqueue_slot_{{queueType == BuildingQueue.TYPE_RESOURCES ? 'fields' : 'village'}}_medium_flat_black"></i>
				<div ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && !buildingQueue.data.queues[queueType][slotDetails.slot]" class="buildingQueueSlot entityBox noClick"
					 ng-class="{empty: availableMasterBuilderSlots >= slotDetails.slot+1, locked: availableMasterBuilderSlots < slotDetails.slot+1}">
					<div ng-if="availableMasterBuilderSlots >= slotDetails.slot+1">
						<div class="topLeftBorder"></div>
						<div class="bottomRightBorder"></div>
						<i class="slotIcon builderIcon feature_masterbuilder_small_flat_black"></i>
					</div>
					<i ng-if="availableMasterBuilderSlots < slotDetails.slot+1" class="slotIcon lockedState symbol_lock_small_flat_black"></i>
				</div>
			</div>

			<div class="detailsInfo subContainer">
				<div ng-if="buildingQueue.data.queues[queueType][slotDetails.slot]">
					<span translate options="{{buildingQueue.data.queues[queueType][slotDetails.slot].buildingType}}">Building_?</span>
						<span ng-if="buildingQueue.data.queues[queueType][slotDetails.slot] && queueType != BuildingQueue.TYPE_DESTRUCTION" class="levelText"
							  translate data="current:{{queueType == BuildingQueue.TYPE_MASTER_BUILDER ? slotDetails.level : buildingsByLocation[buildingQueue.data.queues[queueType][slotDetails.slot].locationId].data.lvl}},
							  next:{{(queueType == BuildingQueue.TYPE_MASTER_BUILDER ? slotDetails.level : buildingsByLocation[buildingQueue.data.queues[queueType][slotDetails.slot].locationId].data.lvl)+1}}">BuildingQueue.Details.LevelChange</span>
				</div>
				<div ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && buildingQueue.data.queues[queueType][slotDetails.slot] && slotDetails.notEnoughResources && !buildingQueue.data.queues[queueType][slotDetails.slot]['paid']"
					 class="slotStatus impediment" translate>BuildingQueue.Details.NotEnoughResources</div>
				<div ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && !buildingQueue.data.queues[queueType][slotDetails.slot] && availableMasterBuilderSlots >= slotDetails.slot+1"
					 translate data="digit:{{slotDetails.slot+1}}">BuildingQueue.Details.SlotAvailable</div>
				<div ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && !buildingQueue.data.queues[queueType][slotDetails.slot] && availableMasterBuilderSlots < slotDetails.slot+1">
					<div class="slotStatus impediment" translate>BuildingQueue.Details.SlotLocked</div>
					<span translate>BuildingQueue.Details.ActivateText</span>
				</div>
				<div ng-if="queueType != BuildingQueue.TYPE_MASTER_BUILDER && !buildingQueue.data.queues[queueType][slotDetails.slot]">
					<div translate options="{{player.data.tribeId == ROMAN ? queueType : 0}}">BuildingQueue.Details.SlotName_?</div>
					<span class="slotStatus" translate>BuildingQueue.Details.NotInUse</span>
				</div>

				<div ng-if="buildingQueue.data.queues[queueType][slotDetails.slot] && !slotDetails.notEnoughResources && slotDetails.startTime >= 0" class="detailsTime">
					<i class="symbol_clock_small_flat_black duration"></i>
					<span countdown="{{slotDetails.startTime || buildingQueue.data.queues[queueType][slotDetails.slot].finished}}"></span>
					<span ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && slotDetails.building[queueType] && slotDetails.building[queueType].data.nextUpgradeTimes[slotDetails.level]">
						 <b>+</b> {{slotDetails.building[queueType].data.nextUpgradeTimes[slotDetails.level]|HHMMSS}}
					</span>
				</div>
			</div>

			<div class="detailsButtonContainer subContainer" ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && availableMasterBuilderSlots < slotDetails.slot+1">
				<button ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && availableMasterBuilderSlots < slotDetails.slot+1"
						clickable="openWindow('confirmGoldUsage', {'feature': PremiumFeature.FEATURE_NAME_BOOK_BUILD_MASTER_SLOT})"
						class="premium" ng-class="{disabled: slotDetails.slot > availableMasterBuilderSlots}" tooltip tooltip-translate-switch="{
						'Building.BookSlotTooltip': {{slotDetails.slot == availableMasterBuilderSlots}},
						'Building.BookSlotTooltip.NotNext': {{slotDetails.slot > availableMasterBuilderSlots}}}"
						tooltip-data="slotPrice:{{slotPrices['price'+(availableMasterBuilderSlots < 2 ? '' : (availableMasterBuilderSlots))]}}">
					<i class="symbol_plus_small_flat_black"></i>
				</button>
			</div>
			<div class="detailsButtonContainer subContainer"
				 ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && buildingQueue.data.queues[queueType][slotDetails.slot] && slotDetails.notEnoughResources && !buildingQueue.data.queues[queueType][slotDetails.slot]['paid']">
				<button premium-feature="{{::PremiumFeature.FEATURE_NAME_NPC_TRADER}}" confirm-gold-usage="true" ng-class="{disabled: activeVillage.isWWVillage() || slotDetails.npcTradingTimeBoost < 0}"
						class="premium" tooltip tooltip-translate-switch="{
							'Error.NotAvailableInWW': {{activeVillage.isWWVillage()}},
							'Building.npcTrader.Tooltip.Possible': {{!activeVillage.isWWVillage() && !slotDetails.npcTradingTimeBoost && !vouchers.data.hasVouchers.NPCTrader}},
							'Building.npcTrader.Tooltip.PossibleWithVoucher': {{!activeVillage.isWWVillage() && !slotDetails.npcTradingTimeBoost && vouchers.data.hasVouchers.NPCTrader}},
							'Building.npcTrader.Tooltip.PossibleButNoEnoughRes': {{!activeVillage.isWWVillage() && slotDetails.npcTradingTimeBoost > 0 && !vouchers.data.hasVouchers.NPCTrader}},
							'Building.npcTrader.Tooltip.PossibleWithVoucherButNoEnoughRes': {{!activeVillage.isWWVillage() && slotDetails.npcTradingTimeBoost > 0 && vouchers.data.hasVouchers.NPCTrader}},
							'Building.npcTrader.Tooltip.Insignificant': {{!activeVillage.isWWVillage() && slotDetails.npcTradingTimeBoost < 0}}}"
						tooltip-data="featurePrice:{{::npcTraderPrice}},timePeriod:{{slotDetails.npcTradingTimeBoost}}">
					<i class="feature_npcTrader_small_flat_black" ng-class="{disabled: activeVillage.isWWVillage() || slotDetails.npcTradingTimeBoost}"></i>
				</button>
			</div>
			<div class="detailsButtonContainer subContainer"
				 ng-if="queueType == BuildingQueue.TYPE_MASTER_BUILDER && buildingQueue.data.queues[queueType][slotDetails.slot] && !buildingQueue.data.queues[queueType][slotDetails.slot]['paid'] && !slotDetails.notEnoughResources">
				<button clickable="reserveResources({{buildingQueue.data.queues[queueType][slotDetails.slot]['id']}})" ng-class="{disabled: !slotDetails.canPayNow}"
						tooltip tooltip-translate-switch="{
							'BuildingQueue.Details.Tooltip.ReserveResources': {{slotDetails.canPayNow}},
							'BuildingQueue.Details.Tooltip.ReservePrevious': {{!slotDetails.canPayNow}}
						}">
					<i class="unit_resources_medium_illu" ng-class="{disabled: !slotDetails.canPayNow}"></i>
				</button>
			</div>
			<div class="detailsButtonContainer subContainer" ng-if="queueType != BuildingQueue.TYPE_MASTER_BUILDER && buildingQueue.data.queues[queueType][slotDetails.slot]">
				<button premium-feature="{{::PremiumFeature.FEATURE_NAME_FINISH_NOW}}" class="premium"
						premium-callback-param="finishNowQueueType:{{queueType}}"
						confirm-gold-usage="true"
						tooltip tooltip-url="tpl/npcTrader/finishNowTooltip.html"
						ng-repeat="n in [buildingQueue.data.queues[queueType][slotDetails.slot].id]">
					<i class="feature_instantCompletion_small_flat_black"></i>
				</button>
			</div>

			<div progressbar ng-if="queueType != BuildingQueue.TYPE_MASTER_BUILDER && buildingQueue.data.queues[queueType][slotDetails.slot]"
						 type="{{queueType == BuildingQueue.TYPE_DESTRUCTION ? 'negative' : ''}}" finish-time="{{buildingQueue.data.queues[queueType][slotDetails.slot].finished}}"
						 duration="{{buildingQueue.data.queues[queueType][slotDetails.slot].finished - buildingQueue.data.queues[queueType][slotDetails.slot].timeStart}}"
						 perc-tooltip="true"></div>
			<div class="emptyBar" ng-if="queueType != BuildingQueue.TYPE_MASTER_BUILDER && !buildingQueue.data.queues[queueType][slotDetails.slot]"></div>
		</div>

		<div class="detailsRow" ng-if="slotDetails.queue == BuildingQueue.TYPE_MASTER_BUILDER && buildingQueue.data.queues[slotDetails.queue][slotDetails.slot]"
			 ng-class="{paid: buildingQueue.data.queues[slotDetails.queue][slotDetails.slot]['paid']}">
			<display-resources resources="buildingsByLocation[buildingQueue.data.queues[slotDetails.queue][slotDetails.slot].locationId].data.nextUpgradeCosts[slotDetails.level]" available="activeVillage.data.calculatedStorage"></display-resources>
		</div>
		<div class="detailsRow" ng-if="slotDetails.queue == BuildingQueue.TYPE_DESTRUCTION && buildingsByLocation[buildingQueue.data.queues[slotDetails.queue][slotDetails.slot].locationId].data.rubble">
			<display-resources resources="buildingsByLocation[buildingQueue.data.queues[slotDetails.queue][slotDetails.slot].locationId].data.rubble" color-positive="true" signed="true" check-storage="true"></display-resources>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/buildingQueueTooltip.html"><b><span translate options="{{buildingQueue.data.queues[queueType][slotDetails.slot].buildingType}}">Building_?</span>
 -
<span translate data="lvl: {{slotDetails.building.data.lvl}}">Building.Level</span></b>
<div translate options="{{::queueType}},{{buildingQueue.data.queues[queueType][slotDetails.slot].isRubble == 1 ? '_Rubble' : ''}}"
	 data="time: {{slotDetails.startTime > 0 ? slotDetails.startTime : buildingQueue.data.queues[queueType][slotDetails.slot].finished}}">
	BuildingQueue.Details.Tooltip.TimeUntil_??
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/buildingQuicklinks.html"><div class="buildingQueueSlots">
	<div class="units slotWrapper">
		<div ng-if="!hideMarketplace" class="slotContainer"
			 clickable="gotoBuilding({{market.locationId}})"
			 ng-class="{disabled: market.state == 'disabled'}"
			 tooltip tooltip-url="tpl/mainlayout/partials/marketplaceTooltip.html" tooltip-placement="below">
			<div class="slot">
				<i ng-class="{
						building_g17_small_flat_white: market.state == 'normal' || market.state == 'disabled',
						building_g17_small_flat_green: market.state == 'active',
						disabled: market.state == 'disabled'
					}">
				</i>
			</div>
		</div>
		<div ng-repeat="item in unitBuilding" class="slotContainer"
			 clickable="gotoBuilding({{item.locationId}})"
			 ng-class="{disabled: item.state == 'disabled'}"
			 tooltip tooltip-url="tpl/mainlayout/partials/unitQueueTooltip.html" tooltip-placement="below">
			<div class="slot">
			 	<i ng-class="{
						building_g{{item.buildingType}}_small_flat_white: item.state == 'normal' || item.state == 'disabled',
						building_g{{item.buildingType}}_small_flat_green: item.state == 'active',
						disabled: item.state == 'disabled'
					}">
				</i>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/buildingStatus.html"><div class="buildingStatus location{{building.data.locationId}}"
	 ng-class="{disabled: upgradeButtonClass == 'notAtAll' || upgradeButtonClass == 'maxLevel',
	 			busy: busy, queued: finished < 0, waiting: waiting, master: finished > 0 && !busy,
	 			optionMenu: upgradeButtonClass == 'notNow' || premiumOptionMenu.locationId == building.data.locationId}"
	 on-pointer-over="premiumOptionMenu.locationId != building.data.locationId && upgradeButtonClass == 'notNow' && !isRubble ? upgradeBuilding() : ''"
	 tooltip tooltip-url="{{upgradeButtonTooltipUrl}}" tooltip-class="buildingTooltip" tooltip-placement="above" tooltip-offset="10"
	 tooltip-hide="{{!player.isOnMap()}}" tooltip-hide-on-click="false">
	<div class="buildingBubble clickable"
		 ng-class="{disabled: upgradeButtonDisabled === true || premiumOptionMenu.locationId == building.data.locationId, disabledHover: upgradeButtonClass == 'notNow'}">
		<div class="colorLayer {{premiumOptionMenu.locationId == building.data.locationId ? 'premiumMenu' : upgradeButtonClass}}"
			 ng-class="{disabled: upgradeButtonClass == 'notAtAll', dismantle: isRubble, enoughRes: !isRubble && enoughRes && freeMasterSlots > 0}">
			<div class="labelLayer">
				<span ng-if="!isRubble" class="buildingLevel">{{building.data.lvl}}</span>
				<i ng-if="isRubble" class="action_dismantle_small_flat_black"></i>
				<i ng-if="upgradeButtonClass == 'maxLevel'" class="symbol_star_tiny_illu"></i>
			</div>
		</div>
	</div>
	<div class="premiumOptionMenu upgradeMenu_background_layout {{::animationClass}}"
		 ng-if="premiumOptionMenu.locationId == building.data.locationId">
		<div class="buildingBubble"
			 clickable="upgradeBuilding()"
			 ng-class="{disabled: upgradeButtonClass == 'notAtAll'}">
			<div class="colorLayer {{upgradeButtonClass}}" ng-class="{disabled: upgradeButtonClass == 'notAtAll', enoughRes: enoughRes && freeMasterSlots > 0}">
				<div class="labelLayer" ng-if="!premiumOptionMenu.options.masterBuilder || canReserveResources">
					<span class="buildingLevel">{{building.data.lvl}}</span>
				</div>
				<i class="feature_buildingMaster_medium_illu" ng-if="premiumOptionMenu.options.masterBuilder && !canReserveResources"></i>
				<i class="symbol_plus_tiny_flat_black" ng-if="upgradeButtonClass == 'notNow' && !canReserveResources"></i>
			</div>
		</div>
		<div class="premiumBubble instantCompletion"
			 ng-class="{optional: !enoughRes || freeSlots}"
			 premium-feature="{{::FinishNowFeatureName}}"
			 premium-callback-param="finishNowQueueType:{{buildingQueue.getBlockingQueueType(building)}}"
			 confirm-gold-usage="true"
			 tooltip tooltip-url="tpl/npcTrader/finishNowTooltip.html"
			 on-pointer-over="$root.$broadcast('hideTooltip');">
			<i class="feature_instantCompletion_small_flat_black"></i>
		</div>
		<div ng-if="premiumOptionMenu.options.onlyQueue" class="premiumBubble onlyQueue"
			 ng-class="{disabled: !enoughRes || freeMasterSlots == 0}"
			 clickable="onlyQueue()"
			 tooltip tooltip-translate="Building.onlyQueue"
			 on-pointer-over="$root.$broadcast('hideTooltip');">
			<i class="feature_buildingMaster_small_illu"></i>
		</div>
		<div ng-if="!premiumOptionMenu.options.onlyQueue && vouchers.data.hasVouchers.NPCTrader == 1" class="premiumBubble premium npcTrader"
			 ng-class="{disabled: !premiumOptionMenu.options.npcTrader || enoughRes, optional: !enoughAfterNPCTrade}"
			 premium-feature="{{::NPCTraderFeatureName}}" confirm-gold-usage="true"
			 on-pointer-over="premiumOptionMenu.options.manualTrader = (premiumOptionMenu.options.npcTrader && !enoughRes); $root.$broadcast('hideTooltip');"
			 tooltip tooltip-translate="Building.npcTrader.Tooltip.{{npcTraderTooltip}}" tooltip-data="featurePrice:0, timePeriod:{{npcTradingTimeBoost}}">
			<i class="feature_npcTrader_small_flat_black"></i>
		</div>
		<div ng-if="!premiumOptionMenu.options.onlyQueue && vouchers.data.hasVouchers.NPCTrader != 1" class="premiumBubble premium npcTrader"
			 ng-class="{disabled: !premiumOptionMenu.options.npcTrader || enoughRes, optional: !enoughAfterNPCTrade}"
			 premium-feature="{{::NPCTraderFeatureName}}" confirm-gold-usage="true"
			 on-pointer-over="premiumOptionMenu.options.manualTrader = (premiumOptionMenu.options.npcTrader && !enoughRes); $root.$broadcast('hideTooltip');"
			 tooltip tooltip-translate="Building.npcTrader.Tooltip.{{npcTraderTooltip}}" tooltip-data="featurePrice:{{::npcTraderPrice}}, timePeriod:{{npcTradingTimeBoost}}">
			<i class="feature_npcTrader_small_flat_black"></i>
		</div>
		<div class="premiumBubble premium small optional manualTrader" ng-if="premiumOptionMenu.options.manualTrader"
			 clickable="callNPCTrader()" tooltip tooltip-translate="Building.npcTrader.Tooltip.Manual" on-pointer-over="$root.$broadcast('hideTooltip');">
			<i class="feature_npcTraderManual_tiny_flat_black"></i>
		</div>
	</div>

	<div progressbar ng-if="finished > 0"
				 clickable="openBuilding()"
				 finish-time="{{finished}}"
				 show-countdown="true"
				 duration="{{duration}}"></div>

	<div progressbar ng-if="finished < 0"
				 clickable="openBuilding()"
				 finish-time="{{finished}}"
				 label="{{masterBuilderDigit}}"
				 duration="{{duration}}"></div>
	<div class="masterBuilder" ng-if="masterBuilderCount > 0">
		<table>
			<tbody>
				<tr>
					<td ng-repeat="n in [] | range:1:masterBuilderCount"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/buildingTooltip.html"><div class="tooltip">
	<span translate options="{{building.data.buildingType}}">Building_?</span>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/carousel.html"><div class="carousel">
	<div class="pages" ng-show="carousel.pages.length > 1">
		<div class="iconButton doubleBorder arrowDirectionFrom" clickable="carousel.previousPage()">
			<i class="symbol_arrowFrom_tiny_flat_black"></i>
		</div>
		<div class="page" ng-repeat="page in carousel.pages" clickable="carousel.goToPage(page)" ng-class="{active: page === carousel.currentPage}"></div>
		<div class="iconButton doubleBorder arrowDirectionTo" clickable="carousel.nextPage()">
			<i class="symbol_arrowTo_tiny_flat_black"></i>
		</div>
	</div>
	<div class="itemContainer">
		<div class="items"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/contextMenuOasisResources.html"><div translate>ContextMenu.button.fetchResources</div>
<display-resources resources="currentRes"></display-resources></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/marketplaceTooltip.html"><div class="queueEntryTooltip">
	<h3 class="queueEntryTitle" translate>Building_17</h3>
	<div class="horizontalLine"></div>

	<div class="subinfo" ng-if="market.state == 'disabled'" translate>Building.NotBuildYet</div>

	<div class="subinfo" ng-if="market.state != 'disabled'">
		<span translate data="free: {{merchants.data.merchantsFree}}, total: {{merchants.data.max}}">Marketplace.Overview.Merchants.Free</span><br>
		<span translate data="blocked: {{merchants.data.inOffers}}, total: {{merchants.data.max}}">Marketplace.Overview.Merchants.BlockedByOffers</span><br>
		<span translate data="blocked: {{merchants.data.inTransport}}, total: {{merchants.data.max}}">Marketplace.Overview.Merchants.BlockedByTransports</span>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mainlayout/partials/resourceTooltip.html"><div class="resourceTooltip">
	<h3 translate options="{{resNames[n]}}">?</h3>
	<div class="horizontalLine"></div>
	<table class="transparent">
		<tr ng-if="village.data.production[n] > 0">
			<th translate>Resource.FullIn</th>
			<td>{{Math.max(0, Math.floor(((village.data.storageCapacity[n] - village.data.calculatedStorage[n]) / village.data.production[n]) * 3600))|HHMMSS}}</td>
		</tr>
		<tr ng-if="village.data.production[n] < 0">
			<th translate>Resource.EmptyIn</th>
			<td>{{Math.max(0, Math.floor((village.data.calculatedStorage[n] / (-village.data.production[n])) * 3600))|HHMMSS}}</td>
		</tr>
		<tr ng-if="resNames[n] == 'crop'">
			<th translate>Resource.BruttoProduction</th>
			<td ng-class="{positiveProduction: village.data.production[n] > 0, negativeProduction: village.data.production[n] < 0}">
				{{(1 * village.data.production[n] + 1 * village.data.supplyBuildings + 1 * village.data.supplyTroops) | bidiNumber : '' : true}}
			</td>
		</tr>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/scrollable.html"><div class="scrollContentOuterWrapper">
	<div class="scrollContent">
		<div class="scrollContentInnerWrapper" ng-transclude></div>
	</div>
</div>
<div class="scrollTrack">
    <div class="scrollHandle"></div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/searchVillage.html"><div class="searchVillage">
	<h6 translate>Target</h6>

	<div class="error" ng-class="{success: api.result.villageReturned}">
		<serverautocomplete class="villageName"
							disable-search="{{disableSearch}}"
							autocompletedata="playerVillages,village,coords,emptyCoords"
							autocompletecb="selectVillage"
							ng-model="api.result.villageSearched"
							input-autofocus="{{inputAutoFocus}}"
							show-own-villages="{{showOwnVillages}}"></serverautocomplete>
	</div>
	<div ng-show="api.target.villageId > 0">
		<div class="horizontalLine"></div>
		<table class="transparent">
			<tr>
				<th translate>TableHeader.Village</th>
				<td>
					<span village-link villageId="{{api.target.villageId}}" villageName="{{api.target.villageName}}"></span>
				</td>
			</tr>
			<tr ng-if="api.target.destPlayerId !== null">
				<th translate>TableHeader.Player</th>
				<td data-village-type="{{api.target.villageType}}" data-is-governor-npc="{{api.target.isGovernorNPCVillage}}" class="playerVillage">
					<span player-link playerId="{{api.targetPlayer.data.playerId}}"></span>
				</td>
			</tr>
			<tr ng-if="api.targetPlayer.data.allianceId > 0">
				<th translate>TableHeader.Alliance</th>
				<td>
					<alliance-link allianceId="{{api.targetPlayer.data.allianceId}}"
								   allianceName="{{api.targetPlayer.data.allianceTag}}"></alliance-link>
				</td>
			</tr>
			<tr ng-show="showDuration && showDuration != 'false'">
			<th translate>TableHeader.Duration</th>
				<td>{{api.target.duration|HHMMSS}}</td>
			</tr>
			<tr ng-show="showDistance && showDistance != 'false'">
			<th translate>TableHeader.Distance</th>
				<td>{{api.target.distance | number:2}}</td>
			</tr>
		</table>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/slider.html"><div class="sliderContainer unselectable" ng-class="{locked: sliderLock}" touch-tooltips>
	<div class="trackContainer">
		<div class="track">
			<div ng-if="stepCount && !hideSteps" class="stepContainer">
				<div ng-repeat="n in [] | range:0:stepCount" class="sliderStep"
					 ng-style="{width: (Math.min((n/stepCount*100),100))+'%'}"></div>
			</div>
			<div class="sliderMarker progressMarker"></div>
			<div ng-repeat="marker in sliderMarkers track by $index" class="sliderMarker customMarker{{$index}}"
				 ng-style="{width: (Math.min((marker*100/sliderMax),100))+'%'}"></div>
			<div class="hoverIndicator">
				<div class="hoverValue"></div>
				<div class="indicator"></div>
			</div>
			<div class="handle unselectable"></div>
		</div>
	</div>
	<div class="inputContainer">
		<i class="{{iconClass}}" ng-if="iconClass"></i>
		<input class="value" number ng-model="value"/>
		<div class="iconButton maxButton"
				ng-class="{disabled: sliderData.maxAvailable == 0 || sliderLock}"
				clickable="setMax()">
			<i class="action_setMax_small_flat_black"></i>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/treasureTooltip.html"><div class="kingdomTooltip">
	<h3 translate>SideMenu.Kingdom.Header</h3>
	<div class="horizontalLine"></div>
	<table class="transparent">
		<tr>
			<th><span translate>Resource.Treasures</span>:</th>
			<td>{{treasures.data.treasuresCurrent|bidiNumber:'':false:false:false:true}}</td>
		</tr>
		<tr>
			<th><span translate>SideMenu.Kingdom.TreasureIncreaseLatestWeek</span>:</th>
			<td>{{treasures.data.treasuresCurrent - treasures.data.treasuresLatestWeek|bidiNumber:'':true:false:false:true}}</td>
		</tr>
		<tr ng-if="player.data.allianceId > 0">
			<th><span translate>Treasury.Victorypoints</span>:</th>
			<td>{{victoryPoints|bidiNumber:'':false:false:false:true}}</td>
		</tr>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/troopMovementIncomingTooltip.html"><div class="troopOverviewTooltip">
	<h3>{{ movementGroup.length }} <span translate options="{{movementGroup.name}}">TroopMovementInfo_?</span></h3>
	<div ng-if="movementGroup.name == 'incoming_healing'" translate>TroopMovementInfo_incoming_healing_additional</div>
    <span ng-if="movementGroup.length > 0">
        <span ng-repeat="idx in [0,1,2]" ng-show="$index<movementGroup.length">
			<div class="horizontalLine"></div>
			<table class="transparent">
				<tr>
					<th>{{ movementGroup[$index].data.movement.playerNameStart }}</th>
					<td><span countdown="{{ movementGroup[$index].data.movement.timeFinish }}"></span></td>
				</tr>
				<tr class="village">
					<th>{{ movementGroup[$index].data.movement.villageNameStart }}</th>
					<td><span i18ndt="{{ movementGroup[$index].data.movement.timeFinish }}" format="mediumTime"></span>
					</td>
				</tr>
			</table>
        </span>
    </span>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/troopMovementIncomingTradeTooltip.html"><div class="troopOverviewTooltip">
	<h3>{{ movementGroup.length }} <span translate options="{{movementGroup.name}}">TroopMovementInfo_?</span></h3>
    <span ng-if="movementGroup.length > 0">
        <span ng-repeat="idx in [0,1,2]" ng-show="$index<movementGroup.length">
			<div class="horizontalLine"></div>
			<table class="transparent">
				<tr>
					<th>{{ movementGroup[$index].data.movement.playerNameStart }}</th>
					<td><span countdown="{{ movementGroup[$index].data.movement.timeFinish }}"></span></td>
				</tr>
				<tr class="village">
					<th>{{ movementGroup[$index].data.movement.villageNameStart }}</th>
					<td><span i18ndt="{{ movementGroup[$index].data.movement.timeFinish }}" format="mediumTime"></span>
					</td>
				</tr>
			</table>
			<display-resources resources="movementGroup[$index].data.movement.resources"></display-resources>
        </span>
    </span>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/troopMovementOutgoingTooltip.html"><div class="troopOverviewTooltip">
	<h3>{{ movementGroup.length }} <span translate options="{{movementGroup.name}}">TroopMovementInfo_?</span></h3>
	<span ng-if="movementGroup.length > 0">
		<span ng-repeat="idx in [0,1,2]" ng-show="$index<movementGroup.length">
			<div class="horizontalLine"></div>
			<table class="transparent">
				<tr>
					<th>{{ movementGroup[$index].data.movement.playerNameTarget }}</th>
					<td><span countdown="{{ movementGroup[$index].data.movement.timeFinish }}"></span></td>
				</tr>
				<tr class="village">
					<th>{{ movementGroup[$index].data.movement.villageNameTarget }}</th>
					<td><span i18ndt="{{ movementGroup[$index].data.movement.timeFinish }}" format="mediumTime"></span>
					</td>
				</tr>
			</table>
		</span>
	</span>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/troopMovementOutgoingTradeTooltip.html"><div class="troopOverviewTooltip">
	<h3>{{ movementGroup.length }} <span translate options="{{movementGroup.name}}">TroopMovementInfo_?</span></h3>
    <span ng-if="movementGroup.length > 0">
		<span ng-repeat="idx in [0,1,2]" ng-show="$index<movementGroup.length">
			<div class="horizontalLine"></div>
			<table class="transparent">
				<tr>
					<th>{{ movementGroup[$index].data.movement.playerNameTarget }}</th>
					<td>
						<span class="recurrences" ng-if="movementGroup[$index].data.movement.merchants > 0 && movementGroup[$index].data.movement.recurrencesTotal > 1" ng-bind-html="movementGroup[$index].data.movement.recurrences | bidiRatio : movementGroup[$index].data.movement.recurrences : movementGroup[$index].data.movement.recurrencesTotal"></span>
						<span countdown="{{ movementGroup[$index].data.movement.timeFinish }}"></span>
					</td>
				</tr>
				<tr class="village">
					<th>{{ movementGroup[$index].data.movement.villageNameTarget }}</th>
					<td><span i18ndt="{{ movementGroup[$index].data.movement.timeFinish }}" format="mediumTime"></span>
					</td>
				</tr>
			</table>
			<display-resources resources="movementGroup[$index].data.movement.resources"></display-resources>
		</span>
	</span>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/troopMovementReturnTooltip.html"><div class="troopOverviewTooltip">
	<h3>{{ movementGroup.length }} <span translate options="{{movementGroup.name}}">TroopMovementInfo_?</span></h3>
    <span ng-if="movementGroup.length > 0">
        <span ng-repeat="idx in [0,1,2]" ng-show="$index<movementGroup.length">
			<div class="horizontalLine"></div>
			<table class="transparent">
				<tr>
					<th translate colspan="2">TroopMovementInfo.From</th>
					<td>{{ movementGroup[$index].data.movement.villageNameStart }}</td>
				</tr>
				<tr class="village">
					<th translate>TroopMovementInfo.In</th>
					<td><span countdown="{{ movementGroup[$index].data.movement.timeFinish }}"></span></td>
					<td><span i18ndt="{{ movementGroup[$index].data.movement.timeFinish }}" format="mediumTime"></span>
					</td>
				</tr>
			</table>
        </span>
    </span>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/troopTypeTooltip.html"><div class="stationedUnitTooltip" ng-init="troopId = getTroopId(group['tribeId'], unitId)">
	<h3>
		<span translate options="{{troopId}}">Troop_?</span>
		<span ng-if="group.unitLevels[unitId]">(<span translate>Units.Research.Level</span> {{group.unitLevels[unitId]}})</span>
	</h3>
	<div class="horizontalLine"></div>
	<div class="troopDetails">
		<div class="troopIcon">
			<span unit-icon big="true" data="group['tribeId'], unitId"></span>
		</div>
		<div class="unitAttributes" ng-if="unitId != Troops.TYPE_HERO">
			<span><i class="movement_attack_small_flat_black"></i>{{group.unitValues[unitId].attack || troopConfig[troopId].attack}}</span>
			<span><i class="unit_defenseInfantry_small_flat_black"></i>{{group.unitValues[unitId].defence || troopConfig[troopId].defence}}</span>
			<br>
			<span><i class="unit_defenseCavalry_small_flat_black"></i>{{group.unitValues[unitId].defenceCavalry || troopConfig[troopId].defenceCavalry}}</span>
			<span><i class="unit_capacity_small_flat_black"></i>{{troopConfig[troopId]['carry']}}</span>
		</div>
		<div class="unitAttributes" ng-if="unitId == Troops.TYPE_HERO">
			<span ng-class="{noValue : group.unitValues[unitId].attack < 0 }"><i class="movement_attack_small_flat_black"></i>{{group.unitValues[unitId].attack < 0 ? '?' : group.unitValues[unitId].attack}}</span>
			<span ng-class="{noValue : group.unitValues[unitId].defence < 0 }"><i class="unit_defenseInfantry_small_flat_black"></i>{{group.unitValues[unitId].defence < 0 ? '?' : group.unitValues[unitId].defence}}</span>
			<br>
			<span ng-class="{noValue : group.unitValues[unitId].defenceCavalry < 0 }"><i class="unit_defenseCavalry_small_flat_black"></i>{{group.unitValues[unitId].defenceCavalry < 0 ? '?' : group.unitValues[unitId].defenceCavalry}}</span>
			<span><i class="unit_capacity_small_flat_black"></i>0</span>
		</div>
	</div>
	<div class="homeTroops troopDetails" ng-if="unit['distribution']['own']">
		<div class="horizontalLine"></div>
		<div class="playerNameVillageNameWrapper">
			<div class="playerName"><span player-link playerId="{{unit['distribution']['own']['player']}}" nolink="true" playerName=""></span></div>
			<div class="villageName"><span village-link villageId="{{unit['distribution']['own']['village']}}" nolink="true" villageName=""></span></div>
		</div>
		<div class="amount" ng-if="unitId != Troops.TYPE_HERO">{{unit['distribution']['own']['amount']}}</div>
		<div class="heroLevel" ng-if="unitId == Troops.TYPE_HERO">
			<span translate>Units.Tooltip.Lvl</span>
			<span class="level">{{unit['distribution']['own']['heroLvl']}}</span>
		</div>
	</div>
	<div class="homeTroops troopDetails" ng-repeat="support in unit['distribution']['support'] track by $index">
		<div class="horizontalLine"></div>
		<div class="playerNameVillageNameWrapper">
			<div class="playerName"><span player-link playerId="{{support['player']}}" nolink="true" playerName=""></span></div>
			<div class="villageName"><span village-link villageId="{{support['village']}}" nolink="true" villageName=""></span></div>
		</div>
		<div class="amount" ng-if="unitId != Troops.TYPE_HERO">{{support['amount']}}</div>
		<div class="heroLevel" ng-if="unitId == Troops.TYPE_HERO">
			<span translate>Units.Tooltip.Lvl</span>
			<span class="level">{{support['heroLvl']}}</span>
		</div>

	</div>
	<div class="troopDetails rest" ng-if="unit['distribution']['others']['sum'] > 0">
		<div class="horizontalLine"></div>
		<div class="playerNameVillageNameWrapper">
			<span translate data="amount:{{unit['distribution']['others']['count']}}">TroopOverview.RestVillages</span>
		</div>
		<div class="amount">{{unit['distribution']['others']['sum']}}</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/unitQueueTooltip.html"><div class="queueEntryTooltip" ng-if="item.state == 'disabled'">
	<h3 translate options="{{item.buildingType}}">Building_?</h3>
	<div class="horizontalLine"></div>
	<div class="subinfo" translate>Building.NotBuildYet</div>
</div>

<div class="queueEntryTooltip" ng-if="item.state == 'normal'">
	<h3 class="queueEntryTitle" translate options="{{item.buildingType}}">Building_?</h3>
	<div class="horizontalLine"></div>
	<div class="subinfo" translate>Building.NothingInQueue</div>
</div>

<div class="queueEntryTooltip" ng-if="item.state == 'active'">
	<table class="transparent">
		<tr class="unitQueueTitle">
			<th class="queueEntryTitle">
				<h3 class="queueEntryTitle" translate options="{{item.buildingType}}">Building_?</h3>
			</th>
			<th class="time">
				<span translate data="countdownTo:{{item.lastFinished}}">countdownTo</span>
			</th>
		</tr>
	</table>
	<div class="horizontalLine"></div>
	<table class="transparent">
		<tr ng-repeat="entry in item.queue">
			<td class="subinfo">
				<span>{{entry.count}}x</span> <span translate options="{{entry.unitType}}">Troop_?</span>
			</td>
			<td class="subinfo time">
				<span translate data="countdownTo:{{entry.timeFinishedLast}}">countdownTo</span>
			</td>
		</tr>
	</table>
</div>

</script>
<script type="text/ng-template" id="tpl/mainlayout/partials/villageListPinTooltip.html"><span translate ng-if="pinned">HUD.Villagelist.Unpin</span>
<span translate ng-if="!pinned">HUD.Villagelist.Pin</span></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/hero/attributeTooltip.html"><span translate ng-if="freePoints > 0" data="count: {{freePoints}}">HUD.Hero.TooltipAttributesFreePoints</span>
<span translate ng-if="!(freePoints > 0)">HUD.Hero.TooltipAttributes</span></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/hero/avatarTooltip.html"><span translate ng-if="alive == 'true'">HUD.Hero.TooltipHero</span>
<span translate ng-if="dead == 'true'" data="duration:{{reviveDuration}}">HUD.Hero.HealthTooltipDead</span>
<span translate ng-if="reviving == 'true'" data="duration:{{untilTime}}">HUD.Hero.HealthTooltipReviving</span></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/hero/healthTooltip.html"><span translate>HUD.Hero.HealthTooltipHealth</span>: {{health}}
<div class="horizontalLine"></div>
<span ng-if="alive"><span translate>HUD.Hero.HealthTooltipRegeneration</span>: {{healthRegeneration}}</span>
<span translate ng-if="dead == 'true'" data="duration:{{reviveDuration}}">HUD.Hero.HealthTooltipDead</span>
<span translate ng-if="reviving == 'true'" data="duration:{{untilTime}}">HUD.Hero.HealthTooltipReviving</span></script>
<script type="text/ng-template" id="tpl/mainlayout/partials/hero/xpTooltip.html"><span translate>HUD.Hero.ExperienceTooltip</span>: {{0 | bidiRatio:xpAchieved:xpNeeded}}</script>
<script type="text/ng-template" id="tpl/maintenance/maintenance.html"><div id="maintenance" ng-controller="maintenanceCtrl">
	<div class="subject" >{{maintenance.data.messageTitle}}</div>
	<div class="message" ng-bind-html="maintenance.data.messageText|toHtml"></div>
</div></script>
<script type="text/ng-template" id="tpl/manual/Manual.html"><div class="inWindowPopup manual">
	<div tabulation tab-config-name="manualTabConfig">
		<div class="inWindowPopupHeader">
			<div class="navigation">
				<a class="back"
				   clickable="back()"
				   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
					<i ng-class="{
						symbol_arrowFrom_tiny_flat_black: !fromHover,
						symbol_arrowFrom_tiny_flat_green: fromHover
					}"></i>
					<span translate>Navigation.Back</span>
				</a>
				|
				<a class="forward"
				   clickable="forward()"
				   on-pointer-over="toHover = true" on-pointer-out="toHover = false">
					<span translate>Navigation.Forward</span>
					<i ng-class="{
						symbol_arrowTo_tiny_flat_black: !toHover,
						symbol_arrowTo_tiny_flat_green: toHover
					}"></i>
				</a>
			</div>
			<a class="toOverview" ng-if="glossarId != 0" clickable="toOverview()" translate>Navigation.toOverview</a>
			<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
		</div>
		<div class="inWindowPopupContent" ng-include="tabBody_subtab"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/manual/partials/buildingsDetails.html"><div class="contentBox">
	<div class="contentBoxBody">
		<div class="properties" ng-class="{zoomed: imageZoomed}">
			<div class="imageWrapper" clickable="imageZoomed = !imageZoomed">
				<img class="building{{imageZoomed ? 'Full' : 'Big'}} buildingType{{buildingData.buildingType}} tribeId{{imageTribeId}}" src="layout/images/x.gif" alt="" />
				<i class="action_zoomIn_medium_flat_black" ng-show="!imageZoomed"></i>
				<i class="action_zoomOut_medium_flat_black" ng-show="imageZoomed"></i>
			</div>
		</div>

		<div class="needs" ng-show="!imageZoomed">
			<div class="contentBox construction">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content">
						<span translate>Manual.Construction</span>
						<span class="basic">(<span translate>level</span> 1)</span>
					</div>
				</h6>
				<div class="contentBoxBody">
					<div class="valueContainer">
						<span ng-repeat="res in [] | range:1:3"
							  class="valueBox"
							  tooltip
							  tooltip-translate="Resource_{{res}}">
							<i class="unit_{{resources[res]}}_small_illu"></i>{{buildingData.costs[res]}}
						</span>
					</div>
					<div class="horizontalLine"></div>
					<div class="valueContainer">
						<span class="valueBox"
							  tooltip
							  tooltip-translate="Resource_4">
							<i class="unit_{{resources[4]}}_small_illu"></i>{{buildingData.costs[4]}}
						</span>
						<span class="valueBox" tooltip tooltip-translate="Duration">
							<i class="symbol_clock_small_flat_black duration"></i>{{buildingData.time|HHMMSS}}
						</span>
					</div>
				</div>
			</div>

			<div class="contentBox requirements">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content">
						<span translate>Manual.Requirements</span>
						<span class="basic">(<span translate>Manual.Basic</span>)</span>
					</div>
				</h6>
				<div class="contentBoxBody">
					<div class="valueContainer">
						<div class="valueBox" ng-repeat="requirement in buildingData.requirements">
							<span ng-if="requirement.type == 2">
								<span ng-if="requirement.op">
									<a clickable="goToBuilding(requirement.buildingType)" translate options="{{requirement.buildingType}}">Building_?</a>
									<span translate>level</span> {{requirement.minLvl}}
								</span>
								<span ng-if="requirement.op === 0" class="forbiddenBuilding">
									<a clickable="goToBuilding(requirement.buildingType)" translate options="{{requirement.buildingType}}">Building_?</a>
								</span>
							</span>
							<span ng-if="requirement.length > 0  && requirement[0].type == 2">
								<span>
									<a clickable="goToBuilding(requirement[0].buildingType)" translate options="{{requirement[0].buildingType}}">Building_?</a>
									<span translate>level</span> {{requirement[0].minLvl}}
								</span>
							</span>
							<span ng-if="requirement.type == 1" ng-class="{forbiddenBuilding: requirement.op == 1}">
								<span ng-if="requirement.villageType == 4" translate>Manual.RequirementWonderOfTheWorld</span>
								<span ng-if="requirement.villageType == 2" translate>Manual.RequirementCity</span>
								<span ng-if="requirement.villageType == 1" translate>Manual.RequirementMain</span>
							</span>
						</div>
						<span translate class="valueBox" ng-if="!buildingData.requirements">Building.Prerequisite.None</span>
					</div>
				</div>
			</div>
		</div>

		<div class="contentBox description" ng-show="!imageZoomed">
			<div class="contentBoxBody" scrollable>
				<span translate options="{{buildingData.buildingType}}" data="param:{{buildingData.descriptionParam}}">Building.Description_?</span>
				<div class="wikiLink" ng-if="hasWikiUrl">
					<a translate clickable="openWikiUrl();">InGameHelp.WikiLink</a>
				</div>
			</div>
		</div>
	</div>
</div>


</script>
<script type="text/ng-template" id="tpl/manual/partials/buildingsOverview.html"><div ng-repeat="categoryId in [] | range:1:3"
	 class="contentBox">
	<h6 class="contentBoxHeader headerWithArrowEndings">
		<div class="content" translate options="{{categoryId}}">Manual.Building.Category_?</div>
	</h6>
	<div class="contentBoxBody category{{categoryId}}">
		<a class="manualEntry"
		   ng-repeat="building in buildingsData"
		   ng-if="building.category == categoryId"
		   clickable="goToEntry({{building.buildingType}})">
			<span translate options="{{building.buildingType}}">Building_?</span>
		</a>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/manual/partials/miscDetails.html"><div class="contentBox">
	<h6 class="contentBoxHeader headerWithArrowEndings">
		<div class="content">
			<span translate options="{{glossarId}}">Manual.MiscTitle_?</span>
		</div>
	</h6>
	<div class="contentBoxBody">
		<span translate options="{{glossarId}}">Manual.MiscDescription_?</span>
	</div>
</div>

<div class="contentBox links" ng-if="links[glossarId]">
	<h6 class="contentBoxHeader headerTrapezoidal">
		<div class="content">
			<span translate>Manual.RelatedLinks</span>
		</div>
	</h6>
	<div class="contentBoxBody">
		<a ng-repeat="topic in links[glossarId]"
		   clickable="goToEntry(topic)">
			<span translate options="{{topic}}">Manual.MiscTitle_?</span>
		</a>
	</div>
</div>




</script>
<script type="text/ng-template" id="tpl/manual/partials/miscOverview.html"><div class="contentBox">
	<h6 class="contentBoxHeader headerWithArrowEndings">
		<div class="content" translate>Tab.Misc</div>
	</h6>
	<div class="contentBoxBody">
		<a class="manualEntry"
		   ng-repeat="topic in entries"
		   clickable="goToEntry(topic)">
			<span translate options="{{topic}}">Manual.MiscTitle_?</span>
		   </a>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/manual/partials/unitsDetails.html"><div class="contentBox">
	<div class="contentBoxBody">
		<div class="properties" ng-class="{zoomed: imageZoomed}">
			<div class="imageWrapper" clickable="imageZoomed = !imageZoomed">
				<unit-image data="{{troopData.tribe}}, {{troopData.nr}}"
							size="{{imageZoomed ? 'full' : 'big'}}"></unit-image>
				<i class="action_zoomIn_medium_flat_black" ng-show="!imageZoomed"></i>
				<i class="action_zoomOut_medium_flat_black" ng-show="imageZoomed"></i>
			</div>

			<div class="contentBox stats" ng-show="!imageZoomed">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content">
						<span translate>Manual.Stats</span>
						<span class="basic">(<span translate>Manual.Basic</span>)</span>
					</div>
				</h6>
				<div class="contentBoxBody">
					<div class="valueContainer">
						<span class="valueBox" tooltip tooltip-translate="TroopAttribute.Attack">
							<i class="movement_attack_small_flat_black"></i>{{troopData.attack}}
						</span>
						<span class="valueBox" tooltip tooltip-translate="TroopAttribute.DefenseInfantry">
							<i class="unit_defenseInfantry_small_flat_black"></i>{{troopData.defence}}
						</span>
						<span class="valueBox" tooltip tooltip-translate="TroopAttribute.DefenseCavalry">
							<i class="unit_defenseCavalry_small_flat_black"></i>{{troopData.defenceCavalry}}
						</span>
					</div>
					<div class="horizontalLine"></div>
					<div class="valueContainer">
						<span class="valueBox" tooltip tooltip-translate="TroopAttribute.Carry">
							<i class="unit_capacity_small_flat_black"></i>{{troopData.carry}}
						</span>
						<span class="valueBox" tooltip tooltip-translate="TroopAttribute.Speed">
							<i class="unit_speed_small_flat_black"></i>{{troopData.speed}}
						</span>
						<span class="valueBox" tooltip tooltip-translate="TroopAttribute.Consumption">
							<i class="unit_consumption_small_flat_black"></i>{{troopData.supply}}
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="needs" ng-show="!imageZoomed">
			<div class="contentBox training">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content">
						<span translate>Manual.Train</span>
						<span class="basic">(<span translate>Manual.Basic</span>)</span>
					</div>
				</h6>
				<div class="contentBoxBody">
					<div class="valueContainer">
						<span ng-repeat="res in [] | range:1:3"
							  class="valueBox"
							  tooltip
							  tooltip-translate="Resource_{{res}}">
							<i class="unit_{{resources[res]}}_small_illu"></i>{{troopData.costs[res]}}
						</span>
					</div>
					<div class="horizontalLine"></div>
					<div class="valueContainer">
						<span class="valueBox" tooltip tooltip-translate="Duration">
							<i class="symbol_clock_small_flat_black duration"></i>{{troopData.time|HHMMSS}}
						</span>
					</div>
				</div>
			</div>

			<div class="contentBox research">
				<h6 class="contentBoxHeader headerTrapezoidal">
					<div class="content" translate>Manual.Research</div>
				</h6>
				<div class="contentBoxBody" ng-if="troopData.nr == 1 || troopData.nr == Troops.TYPE_SETTLER">
					<div class="valueContainer notNecessary">
						<span translate>Manual.NotNecessary</span>
					</div>
					<div class="horizontalLine"></div>
					<div class="valueContainer buildingsRequired">
						<div class="valueBox" ng-repeat="requirement in troopData.requirements">
							<a clickable="goToBuilding(requirement.buildingType)" translate options="{{requirement.buildingType}}">Building_?</a>
							<span translate>level</span> {{requirement.minLvl}}
						</div>
						<span translate class="valueBox" ng-if="!troopData.requirements">Building.Prerequisite.None</span>
					</div>
				</div>
				<div class="contentBoxBody" ng-if="troopData.nr != 1 && troopData.nr != Troops.TYPE_SETTLER">
					<div class="valueContainer resourcesRequired">
						<span ng-repeat="res in [] | range:1:3"
							  class="valueBox"
							  tooltip
							  tooltip-translate="Resource_{{res}}">
							<i class="unit_{{resources[res]}}_small_illu"></i>{{troopData.research.costs[res]}}
						</span>
					</div>
					<div class="horizontalLine"></div>
					<div class="valueContainer">
						<span class="valueBox" tooltip tooltip-translate="Duration">
							<i class="symbol_clock_small_flat_black duration"></i>{{troopData.research.time|HHMMSS}}
						</span>
					</div>
					<div class="horizontalLine"></div>
					<div class="valueContainer buildingsRequired">
						<div class="valueBox" ng-repeat="requirement in troopData.requirements">
							<a clickable="goToBuilding(requirement.buildingType)" translate options="{{requirement.buildingType}}">Building_?</a>
							<span translate>level</span> {{requirement.minLvl}}
						</div>
						<span translate class="valueBox" ng-if="!troopData.requirements">Building.Prerequisite.None</span>
					</div>
				</div>
			</div>
		</div>

		<div class="contentBox description" ng-show="!imageZoomed">
			<div class="contentBoxBody">
				<div class="descriptionBody" scrollable>
					<span translate options="{{troopData.id}}">Troop.Description_?</span>
					<div class="wikiLink" ng-if="hasWikiUrl">
						<a translate clickable="openWikiUrl();">InGameHelp.WikiLink</a>
					</div>
				</div>
				<div class="stepsContainer">
					<div class="stepButtonsContainer">
						<a class="stepButton" ng-repeat="troop in troopTypes" clickable="changeUnit(troop['order'])" ng-class="{'last':$last, 'active': activeTroopType == troop['order']}">
							<span unit-icon data="troop['data']['tribe'], troop['order']"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</script>
<script type="text/ng-template" id="tpl/manual/partials/unitsOverview.html"><div ng-repeat="tribeId in [] | range:1:3"
	 class="contentBox">
	<h6 class="contentBoxHeader headerWithArrowEndings">
		<div class="content" translate options="{{tribeId}}">Tribe_?</div>
	</h6>
	<div class="contentBoxBody">
		<a class="manualEntry"
		   ng-repeat="unitId in [] | range:1:10"
		   clickable="goToEntry(getGlossarId(tribeId, unitId))">
			<span unit-icon data="tribeId, unitId"></span>
			<span translate options="{{getGlossarId(tribeId, unitId)}}">Troop_?</span>
		   </a>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/manual/tabs/Buildings.html"><div ng-controller="manualBuildingsCtrl">
	<div ng-include class="overview buildingsOverview" ng-if="showOverview" src="'tpl/manual/partials/buildingsOverview.html'"></div>
	<div ng-include class="details buildingsDetails" ng-if="!showOverview" src="'tpl/manual/partials/buildingsDetails.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/manual/tabs/Misc.html"><div ng-controller="manualMiscCtrl">
	<div ng-include class="overview miscOverview" ng-if="showOverview" src="'tpl/manual/partials/miscOverview.html'"></div>
	<div ng-include class="details miscDetails" ng-if="!showOverview" src="'tpl/manual/partials/miscDetails.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/manual/tabs/Units.html"><div ng-controller="manualUnitsCtrl">
	<div ng-include class="overview unitsOverview" ng-if="showOverview" src="'tpl/manual/partials/unitsOverview.html'"></div>
	<div ng-include class="details unitsDetails" ng-if="!showOverview" src="'tpl/manual/partials/unitsDetails.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/mapCellDetails.html"><div class="mapCellDetails" ng-controller="mapCellDetailsCtrl">
	<div scrollable height-dependency="max">
		<div ng-include src="'tpl/mapCellDetails/partials/header.html'"></div>
		<div class="otherContainer {{fieldType}}">
			<div ng-include src="'tpl/mapCellDetails/partials/bodyTop.html'"></div>
			<div ng-include src="'tpl/mapCellDetails/partials/bodyBottom.html'"></div>
		</div>
	</div>
	<div class="cellActionContainer">
		<div class="iconButton centerMapButton"
			 tooltip tooltip-translate="CellDetails.CenterMap"
			 clickable="openPage('map', 'centerId', '{{cellId}}_{{currentServerTime}}'); closeWindow(w.name);">
			<i class="symbol_target_small_flat_black"></i>
		</div>
		<div class="options" ng-if="options.length > 0" more-dropdown more-dropdown-options="getOptions()"></div>
		<button class="sendTroopsButton"
				ng-show="fieldType == 'village' || fieldType == 'oasis' || fieldType == 'npcVillageRobber' || fieldType == 'npcVillageGovernor'" clickable="openWindow('sendTroops', {'x': {{coordinates.x}}, 'y': {{coordinates.y}} })"
				tooltip tooltip-show="{{!hasRallyPoint}}" tooltip-translate="ContextMenu.NoRallyPoint"
				ng-class="{disabled: !hasRallyPoint}">
			<span translate>CellDetails.SendTroops</span>
		</button>
		<button class="sendTroopsButton"
				tooltip tooltip-translate-switch="{
				'CellDetails.button.settle.tooltip': {{!!hasRallyPoint}},
				'ContextMenu.NoRallyPoint': {{!hasRallyPoint}}
			 	}"
				ng-show="fieldType == 'habitable'"
				ng-class="{disabled: !enoughSettlers || !hasRallyPoint}"
				clickable="settleHere()">
			<span translate>CellDetails.button.settle</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/bodyBottom.html"><div ng-if="fieldType == 'oasis'">
	<div ng-include src="'tpl/mapCellDetails/partials/oasisTroops.html'" ng-if="animals"></div>

	<div ng-repeat="troopDetails in troopsHere">
		<troop-details-rallypoint troop-details="troopDetails" view="oasis" render-lazy="false" send-troops="sendTroops(troops, type);"></troop-details-rallypoint>
	</div>
</div>

<div ng-if="fieldType == 'village' && mapDetails.isWonder && !mapDetails.isConquered" class="descriptionContainer">
	<div class="contentBox">
		<div class="contentBoxBody">
			<span translate>Map.Details.NatarCapitalDescription</span>
		</div>
	</div>
</div>

<div class="tributeCropContainer">
	<div class="tributes contentBox gradient" ng-show="showTributes">
		<div class="contentBoxBody" ng-if="activeTreasury">
			<display-resources resources="village.tributes" treasures="village.tributeTreasures"></display-resources>
			<div class="barView">
				<div class="actualTributes">{{0 | bidiRatio:village.tributeSum:village.tributesCapacity}}</div>
				<div progressbar
					class="populationBar"
					type="green"
					perc='{{village.tributePercentage}}'
					marker="{{village.tributeTreasureMarker}}"
					></div>
			</div>
			<button clickable="fetchTributes()" ng-class="{disabled: !village.canFetchTributes}" play-on-click="{{UISound.BUTTON_COLLECT_TRIBUTES}}">
				<span translate>ContextMenu.button.fetchTribute</span>
			</button>
		</div>
		<div class="contentBoxBody" ng-if="!activeTreasury">
			<span translate>Tributes.VillageNotGeneratingInfluence</span>
		</div>
	</div>
	<div class="cropContainer contentBox" ng-if="sharedInformations.cropDetails != null">
		<div class="contentBoxBody">
			<span translate>Building_11</span>

			<div class="stockContainer {{type}}">
				<div progressbar type="{{cropClass}}" label-icon="unit_crop_small_illu"
							 value="{{sharedInformations.cropDetails.current}}" max-value="{{sharedInformations.cropDetails.max}}"></div>
			</div>
			<div class="productionContainer">
				<span data="production:{{sharedInformations.cropDetails.production| bidiNumber:'':true:true}}" translate>Kingdom.Governors.Tributes.ToolTip.ProductionPerHour</span>
			</div>
		</div>
	</div>
</div>

<p ng-show="error" class="error">
	{{error}}
</p>

<div ng-if="fieldType == 'village' || fieldType == 'npcVillageRobber' || fieldType == 'npcVillageGovernor'">
	<div ng-repeat="troopDetails in troopsHere">
		<troop-details-rallypoint troop-details="troopDetails" view="ownSupport" render-lazy="false" send-troops="sendTroops(troops, type);"></troop-details-rallypoint>
	</div>
</div>

<div ng-if="sharedInformations.stationedTroops.length > 0" class="sharedTroopsContainer">
	<div class="troopsDetailContainer" ng-repeat="troopDetails in sharedInformations.stationedTroops">
		<div class="troopsDetailHeader">
			<span options="{{troopDetails.tribeId}}" translate>Tribe_?</span>
			<span class="troopsInfo"><i class="unit_consumption_small_flat_black"></i> {{troopDetails.supplyTroops}} <span translate>perHour</span></span>
		</div>
		<div troops-details troop-data="troopDetails"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/bodyTop.html"><div class="splitContainer {{fieldType}}">
	<div ng-if="fieldType == 'village' && mapDetails.wwValues">
		<div class="contentBox worldWonderProgress">
			<div ng-include src="'tpl/mapCellDetails/partials/worldWonderProgress.html'"></div>
		</div>
	</div>
	<div ng-if="fieldType == 'village'">
		<div class="contentBox">
			<div ng-include src="'tpl/mapCellDetails/partials/villageDetails.html'"></div>
		</div>
		<div class="contentBox">
			<div ng-include src="'tpl/mapCellDetails/partials/landDistribution.html'"></div>
		</div>
	</div>
	<div ng-if="fieldType == 'oasis'">
		<div class="contentBox leftBox">
			<div ng-include src="'tpl/mapCellDetails/partials/oasisDetails.html'"></div>
		</div>
		<div class="contentBox rightBox">
			<div ng-include src="'tpl/mapCellDetails/partials/oasisProduction.html'"></div>
		</div>
	</div>
	<div ng-if="fieldType == 'npcVillageRobber' || fieldType == 'npcVillageGovernor'">
		<div ng-if="mapDetails.npcInfo.type == Village.TYPE_KINGDOM_ROBBER" class="kingdom">
			<div class="charges">
				<div ng-include src="'tpl/mapCellDetails/partials/npcCharges.html'"></div>
			</div>
			<div class="chargeInfo">
				<div class="contentBox gradient chargeDetail">
					<div ng-include src="'tpl/mapCellDetails/partials/npcChargeDetail.html'"></div>
				</div>
				<div class="contentBox gradient lootContainer">
					<div ng-include src="'tpl/mapCellDetails/partials/loot.html'"></div>
				</div>
				<div class="contentBox gradient troopContainer">
					<div ng-include src="'tpl/mapCellDetails/partials/troops.html'"></div>
				</div>
			</div>
		</div>
        <div ng-if="mapDetails.npcInfo.type == Village.TYPE_GOVERNOR_NPC_VILLAGE" class="normal">
            <div class="contentBox">
                <div ng-include src="'tpl/mapCellDetails/partials/npcVillageDetails.html'"></div>
            </div>
            <div class="contentBox lootContainer">
                <div ng-include src="'tpl/mapCellDetails/partials/loot.html'"></div>
            </div>
        </div>
		<div ng-if="mapDetails.npcInfo.type != Village.TYPE_KINGDOM_ROBBER && mapDetails.npcInfo.type != Village.TYPE_GOVERNOR_NPC_VILLAGE" class="normal">
			<div class="contentBox">
				<div ng-include src="'tpl/mapCellDetails/partials/npcVillageDetails.html'"></div>
			</div>
			<div class="contentBox lootContainer">
				<div ng-include src="'tpl/mapCellDetails/partials/loot.html'"></div>
			</div>
            <div class="contentBox gradient troopContainer">
                <div ng-include src="'tpl/mapCellDetails/partials/troops.html'"></div>
            </div>
		</div>
	</div>
	<div ng-if="fieldType == 'unhabitable'">
		<div class="contentBox" ng-if="mapDetails.isWonder">
			<div class="contentBoxBody">
				<span translate>Map.Details.AncientRuinDescription</span>
			</div>
		</div>
	</div>
	<div ng-if="fieldType == 'habitable'">
		<div class="contentBox">
			<div class="contentBoxHeader headerColored">
				<h6><span translate>CellDetails.SettleDetails</span> <span><div coordinates x="{{w.coordinates.x}}" y="{{w.coordinates.y}}"></div></span></h6>
			</div>
			<div class="contentBoxBody">
				<span translate>CellDetails.SettleDescription</span>
			</div>
		</div>
		<div class="contentBox">
			<div ng-include src="'tpl/mapCellDetails/partials/landDistribution.html'"></div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/header.html"><div class="mapContainer {{fieldType}}">
	<div ng-if="mapDetails.isWonder">
		<h6 class="headerTrapezoidal">
			<div ng-if="fieldType=='unhabitable'" class="content" translate>Map.Details.AncientRuin</div>
			<div ng-if="fieldType=='village' && !mapDetails.isConquered" class="content" translate>Map.Details.NatarCapital</div>
			<div ng-if="fieldType=='village' && mapDetails.isConquered" class="content" translate>Map.Details.WonderOfTheWorld</div>
		</h6>
		<div ng-if="mapDetails.wwValues" class="rankContainer">
			<h6 class="headerTrapezoidal">
				<div class="content" translate>Rank</div>
			</h6>
			<div class="rankBody">
				<i class="cellDetails_wwRank_large_illu"></i>
				<div class="worldWonderRank">
					{{mapDetails.wwValues.rank}}
				</div>
				<div class="horizontalLine double"></div>
				<div class="worldWonderBonus">+ {{mapDetails.wwValues.bonus*100 | bidiNumber:"percent"}}</div>
			</div>
		</div>
		<div class="symbol_i_tiny_wrapper">
			<i class="symbol_i_tiny_flat_white" clickable="openWindow('help', {'pageId': 'MilitaryAndDiplomacy_WonderOfTheWorld'})"></i>
		</div>
	</div>
	<div class="oasisIllu type{{mapDetails.oasisType}}" ng-if="fieldType == 'oasis'"></div>
	<div class="robberIllu" ng-if="fieldType == 'npcVillageRobber'"></div>
	<div class="wrapper" ng-if="fieldType != 'oasis' && fieldType != 'npcVillageRobber' && !mapDetails.isWonder">
		<div class="background"></div>
		<div class="foreground resDistribution resources{{resDistribution}}"></div>
	</div>
	<div class="wwIllu" ng-if="mapDetails.isWonder">

	</div>
	<ul class="attackContainer infoMovements unselectable troopMovements" ng-if="showAttack && attackingTroops.cnt == 0">
		<li class="infoMovementType incoming unselectable incoming_attacks">
			<i class="movement_attack_small_flat_black"></i>

			<div class="countdown" countdown="{{sharedInformations.nextAttack}}"></div>
			<div class="count">{{sharedInformations.attackCount}}</div>
			<div class="ending">
				<div class="colored"></div>
			</div>
		</li>
	</ul>
	<ul class="attackContainer infoMovements unselectable troopMovements" ng-if="attackingTroops.cnt > 0">
		<li class="infoMovementType incoming unselectable incoming_attacks">
			<i class="movement_attack_small_flat_black"></i>

			<div class="countdown" countdown="{{attackingTroops.first}}"></div>
			<div class="count">{{attackingTroops.cnt}}</div>
			<div class="ending">
				<div class="colored"></div>
			</div>
		</li>
	</ul>
	<div ng-if="mapDetails.npcInfo.type == 8" class="nextNPCattackWrapper">
		<h6 class="headerTrapezoidal">
			<div class="content" translate data="time:{{mapDetails.npcInfo.nextAttack}}">CellDetails.NextNPCAttack</div>
		</h6>
	</div>
	<div class="oasisBonusWrapper" ng-if="fieldType == 'oasis'">
		<div class="oasisBonusContainer" ng-show="mapDetails.oasisBonus[1] != 0" tooltip tooltip-translate="wood">
			<i class="oasisBonus unit_wood_large_illu"></i>
			<span>{{mapDetails.oasisBonus[1] | bidiNumber:'percent':false:false}}</span>
		</div>
		<div class="oasisBonusContainer" ng-show="mapDetails.oasisBonus[2] != 0" tooltip tooltip-translate="clay">
			<i class="oasisBonus unit_clay_large_illu"></i>
			<span>{{mapDetails.oasisBonus[2] | bidiNumber:'percent':false:false}}</span>
		</div>
		<div class="oasisBonusContainer" ng-show="mapDetails.oasisBonus[3] != 0" tooltip tooltip-translate="iron">
			<i class="oasisBonus unit_iron_large_illu"></i>
			<span>{{mapDetails.oasisBonus[3] | bidiNumber:'percent':false:false}}</span>
		</div>
		<div class="oasisBonusContainer" ng-show="mapDetails.oasisBonus[4] != 0" tooltip tooltip-translate="crop">
			<i class="oasisBonus unit_crop_large_illu"></i>
			<span>{{mapDetails.oasisBonus[4] | bidiNumber:'percent':false:false}}</span>
		</div>
		<h6 class="headerTrapezoidal">
			<div class="content" translate>CellDetails.oasisBonus</div>
		</h6>
	</div>
	<div class="defBonus" ng-if="fieldType == 'oasis'" tooltip tooltip-translate="CellDetails.Oasis.DefBonus" tooltip-data="bonus:{{mapDetails.defBonus}}">
		{{mapDetails.defBonus}}<br>%
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/landDistribution.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6 translate>CellDetails.distribution</h6>
</div>
<div class="contentBoxBody">
	<div class="landDistributionContainer">
		<i class="landDistribution unit_wood_large_illu"></i>
		<span>{{resources.wood}}</span>
	</div><div class="landDistributionContainer">
		<i class="landDistribution unit_clay_large_illu"></i>
		<span>{{resources.clay}}</span>
	</div><div class="landDistributionContainer">
		<i class="landDistribution unit_iron_large_illu"></i>
		<span>{{resources.iron}}</span>
	</div><div class="landDistributionContainer">
		<i class="landDistribution unit_crop_large_illu"></i>
		<span>{{resources.crop}}</span>
	</div>
</div>

</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/loot.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6 translate>CellDetails.Loot</h6>
</div>
<div class="contentBoxBody">
	<div class="loot">
		<div class="horizontalLine"></div>
		<div class="verticalLine"></div>
		<div ng-if="player.data.isKing">
			<display-resources resources="selectedCharge.loot" treasures="selectedCharge.treasures"></display-resources>
		</div>
		<div ng-if="!player.data.isKing">
			<display-resources resources="selectedCharge.loot" stolen-goods="selectedCharge.treasures"></display-resources>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/mapCellHeader.html">	<div class="contentHeader">
		<h2>
			<span>{{w.villageName}}</span>
		</h2>
	</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/npcChargeDetail.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6 translate data="charge:{{selectedCharge.number}}">CellDetails.ChargeDetail.Title</h6>
	<div ng-if="selectedCharge.cleared && selectedCharge.clearedBy > 0" class="framedAvatarImage" clickable="openWindow('profile', {'playerId': {{selectedCharge.clearedBy}}, 'profileTab': 'playerProfile'})">
		<avatar-image player-id="{{selectedCharge.clearedBy}}" avatar-class="profile" class="avatar"></avatar-image>
	</div>
</div>
<div class="contentBoxBody">
	<div ng-if="selectedCharge.locked" translate>CellDetails.ChargeDetail.Locked</div>
	<div ng-if="!selectedCharge.locked && !selectedCharge.cleared" translate>CellDetails.ChargeDetail.Active</div>
	<div ng-if="selectedCharge.cleared && selectedCharge.clearedBy > 0">
		<div translate data="playerId:{{selectedCharge.clearedBy}},playerName:" class="clearedBy">CellDetails.ChargeDetail.ClearedBy</div>
		<div i18ndt="{{selectedCharge.clearedAt}}" format="short"></div>
	</div>
	<div ng-if="selectedCharge.cleared && selectedCharge.clearedBy <= 0" translate>CellDetails.ChargeDetail.NotCleared</div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/npcCharges.html"><a class="clickableContainer" ng-repeat="chargeInfo in mapDetails.npcInfo.charges"
	 ng-class="{cleared: chargeInfo.cleared && chargeInfo.clearedBy >0, notCleared: chargeInfo.cleared && chargeInfo.clearedBy <= 0, active: selectedCharge.number == chargeInfo.number, locked: chargeInfo.locked}"
	clickable="selectCharge({{chargeInfo.number}})">
	<i class="chargeStatus"></i>
	<div ng-if="selectedCharge.number == chargeInfo.number" class="arrow">
		<div class="ending"></div>
		<div class="point"></div>
	</div>
</a></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/npcVillageDetails.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6><span translate>CellDetails.VillageDetails</span> <div coordinates x="{{w.coordinates.x}}" y="{{w.coordinates.y}}"></div></h6>
</div>
<div class="contentBoxBody">
	<table class="transparent">
		<tr>
			<th translate>Owner</th>
			<td><div class="longTitle">
				<span player-link playerId="{{mapDetails.npcInfo.playerId}}" playername=""></span></div>
			</td>
		</tr>
		<tr>
			<th translate>Tribe</th>
			<td translate options="{{mapDetails.npcInfo.tribeId}}">Tribe_?</td>
		</tr>
	</table>
	<div class="npcDescription" translate options="{{mapDetails.npcInfo.type}}">NPCVillageType_?</div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/oasisDetails.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6>
		<span translate>CellDetails.OasisDetails</span>
		<div coordinates x="{{w.coordinates.x}}" y="{{w.coordinates.y}}"></div>
	</h6>
</div>
<div class="contentBoxBody oasisDetails" ng-class="{occupied: !animals}">
	<div ng-if="animals">
		<div class="owner" translate>CellDetails.Oasis.NatureOwner</div>
		<div class="horizontalLine"></div>
		<div translate>CellDetails.Oasis.NatureDescription</div>
	</div>
	<div ng-if="!animals">
		<div class="owner">
			<span><span translate>Kingdom</span>:</span>
			<span ng-if="mapDetails.kingdomId <= 0" translate>CellDetails.Oasis.NoKingdom</span>
			<span player-link ng-if="mapDetails.kingdomId > 0" playerId="{{mapDetails.kingdomId}}" playerName=""></span>
		</div>
		<div class="arrowContainer arrowDirectionTo small" ng-repeat="(rank, details) in mapDetails.playersWithTroops"
			 ng-class="{active: details.playerId > 0, inactive: details.playerId == 0}"
			 tooltip tooltip-url="{{::details.playerId > 0 ? 'tpl/mapCellDetails/partials/oasisRankingTooltip.html' : ''}}"
			 tooltip-data-request="{{::details.playerId > 0 ? 'requestInfluenceData;'+details.playerId : ''}}">
			<span class="arrowInside">{{rank|rank}}<span ng-if="::$last">+</span></span>
			<span class="arrowOutside">
				<span ng-if="details.playerId > 0"><span player-link playerId="{{details.playerId}}" playerName=""></span></span>
				<span ng-if="details.playerId == 0">-</span>
				<span class="bonusPercent">{{details.bonus|bidiNumber:'percent':false:false}}</span>
			</span>
			<div ng-if="details.playerId == player.data.playerId" class="indicationArrow"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/oasisProduction.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6>
		<span translate ng-if="animals && inVillageReach">CellDetails.Oasis.Production.Title.Conquest</span>
		<span translate ng-if="!animals || !inVillageReach">CellDetails.Oasis.Production.Title.Production</span>
	</h6>
</div>
<div class="contentBoxBody oasisProduction" ng-class="{assigned: isInTop5}">
	<div ng-if="!inVillageReach">
		<span translate>CellDetails.Oasis.Production.OutOfReach</span>
	</div>
	<div ng-if="inVillageReach && animals">
		<span translate>CellDetails.Oasis.Production.Wild</span>
	</div>
	<div ng-if="inVillageReach && !animals">
		<div ng-if="!isInTop5">
			<span translate>CellDetails.Oasis.Production.Unassigned</span>
			<button clickable="openWindow('building',{'location': embassyLocationId, 'tab': 'Oases'});" ng-class="{disabled: !activeVillageInReach || embassyLocationId < 0}"
					tooltip tooltip-translate-switch="{	'CellDetails.Oasis.Production.Button.Assign.Tooltip': {{activeVillageInReach && embassyLocationId >= 0}},
														'CellDetails.Oasis.Production.Button.Assign.NoEmbassy.Tooltip': {{activeVillageInReach && embassyLocationId < 0}},
														'CellDetails.Oasis.Production.Button.Assign.TooFarAway.Tooltip': {{!activeVillageInReach}}}">
				<span translate>CellDetails.Oasis.Production.Button.Assign</span>
			</button>
		</div>
		<div ng-if="isInTop5">
			<div class="villageProduction">
				<span village-link villageId="{{mapDetails.ownTroops.usedByVillage}}" villageName=""></span>
				<div class="horizontalLine"></div>
				<div class="resourceBonus" ng-repeat="(type, amount) in villageProductionBonus">
					<span class="bonusValue">{{playerRank[player.data.playerId].bonus|bidiNumber:'percent'}}</span>
					<i class="unit_{{ResourcesModel.STRING[type]}}_small_illu" tooltip tooltip-translate="Resource_{{type}}"></i>
					<span class="productionValue" translate data="value: {{amount}}">PerHour</span>
				</div>
			</div>
			<div class="troopsProduction">
				<div ng-if="inOwnKingdom">
					<span data="troops: {{mapDetails.ownTroops.amount}}, max: {{mapDetails.ownTroops.maxUsableTroops}}" translate>CellDetails.Oasis.Production.Troops</span>
					<div class="horizontalLine"></div>
					<div ng-if="mapDetails.ownTroops.amount > 0">
						<div class="resourceBonus" ng-repeat="(type, amount) in villageProductionBonus">
							<i class="unit_{{ResourcesModel.STRING[type]}}_small_illu" tooltip tooltip-translate="Resource_{{type}}"></i>
							<span class="productionValue" translate data="value: {{mapDetails.ownTroops.troopProduction}}">PerHour</span>
						</div>
					</div>
					<div ng-if="mapDetails.ownTroops.amount == 0">
						<span translate>CellDetails.Oasis.Production.NoTroops</span>
					</div>
				</div>
				<span ng-if="!inOwnKingdom" translate>CellDetails.Oasis.Production.OtherKingdom</span>
			</div>
			<div class="productionTotal">
				<span translate>CellDetails.Oasis.Production.Total</span>
				<div class="resourceBonus" ng-repeat="(type, amount) in villageProductionBonus">
					<i class="unit_{{ResourcesModel.STRING[type]}}_small_illu" tooltip tooltip-translate="Resource_{{type}}"></i>
					<span class="productionValue" translate data="value: {{amount + mapDetails.ownTroops.troopProduction}}">PerHour</span>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/oasisRankingTooltip.html"><div class="oasisRankingTooltip">
	<table class="oasisInfluenceTable transparent">
		<tr>
			<th translate>TableHeader.Village</th>
			<th class="populationDistanceRatio">
				<i class="unit_population_small_flat_black"></i>
				<i class="unit_distance_small_flat_black"></i>
			</th>
			<th></th>
			<th><i class="unit_influence_small_flat_black"></i></th>
		</tr>
		<tr ng-repeat="(i, data) in ::tooltipRequestData.influenceData">
			<td><span village-link villageId="{{::data.villageId}}" villageName="" nolink="true"></span></td>
			<td class="populationDistanceRatio" ng-bind-html="0|bidiRatio:data.population:data.distance:true"></td>
			<td>=</td>
			<td>{{::data.influence}}</td>
		</tr>
	</table>
	<table class="troopsAndTotalTable transparent">
		<tr>
			<td translate>CellDetails.Oasis.Ranking.Tooltip.TroopsInfluence</td>
			<td><span ng-if="::tooltipRequestData.troopsInfluence != '?'">+</span>{{::tooltipRequestData.troopsInfluence}}</td>
		</tr>
		<tr>
			<td translate>CellDetails.Oasis.Ranking.Tooltip.TotalInfluence</td>
			<td>{{::tooltipRequestData.totalInfluence}}<span ng-if="::tooltipRequestData.troopsInfluence == '?'"> + ?</span></td>
		</tr>
	</table>
</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/oasisTroops.html"><div class="contentBox troopContainer" ng-if="oasisTroops">
	<div class="villageDetails contentBoxHeader headerColored">
		<h6 translate>Troops</h6>
	</div>
	<div class="contentBoxBody">
		<div troops-details troop-data="mapDetails.troops"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/troops.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6 translate>Troops</h6>
</div>
<div class="contentBoxBody">
	<div troops-details troop-data="selectedCharge.troops"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/villageDetails.html"><div class="villageDetails contentBoxHeader headerColored">
	<h6><span translate>CellDetails.VillageDetails</span> <div coordinates x="{{w.coordinates.x}}" y="{{w.coordinates.y}}"></div></h6>
	<span class="mainVillageIndicator"><i ng-if="village.isMainVillage" class="village_main_small_flat_black"></i></span>
</div>
<table class="transparent contentBoxBody">
	<tr ng-if="mapDetails.tribe != PlayerModel.TRIBE.NATAR">
		<th translate>Owner</th>
		<td><div class="longTitle">
			<span player-link playerId="{{mapDetails.playerId}}"
						 playerName="{{mapDetails.playerName}}"></span></div>
		</td>
	</tr>
	<tr ng-if="mapDetails.tribe != PlayerModel.TRIBE.NATAR">
		<th translate>King</th>
		<td><div class="longTitle">
			<span player-link ng-if="mapDetails.kingdomId != 0" playerId="{{mapDetails.kingdomId}}"></span>
			<span translate ng-if="mapDetails.kingdomId == 0">None</span>
		</div>
		</td>
	</tr>
	<tr ng-if="mapDetails.tribe != PlayerModel.TRIBE.NATAR">
		<th translate>Alliance</th>
		<td>
			<alliance-link ng-if="mapDetails.allianceId != 0" allianceId="{{mapDetails.allianceId}}"
						   allianceName="{{mapDetails.allianceTag}}"></alliance-link>
			<span translate ng-if="mapDetails.allianceId == 0">None</span>
		</td>
	</tr>
	<tr>
		<th translate>Tribe</th>
		<td translate options="{{mapDetails.tribe}}">Tribe_?</td>
	</tr>
	<tr>
		<th translate>TableHeader.Population</th>
		<td>{{mapDetails.population}}</td>
	</tr>
</table>
</script>
<script type="text/ng-template" id="tpl/mapCellDetails/partials/worldWonderProgress.html"><div class="contentBoxBody">
	<h6 class="headerTrapezoidal">
		<div class="content">
			<span ng-bind-html="mapDetails.wwValues.level | bidiRatio:mapDetails.wwValues.level:wonderMaxLvl"></span>
			<span translate>Map.Details.Levels</span>
		</div>
	</h6>
	<div progressbar perc="{{mapDetails.wwValues.level / (wonderMaxLvl / 100)}}"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/markerMenu/markerMenu.html"><div class="markerMenu" ng-controller="markerMenuCtrl">
    <div class="markerBody">
        <div ng-include="tabBody"></div>
    </div>
</div></script>
<script type="text/ng-template" id="tpl/markerMenu/tabs/AllMarker.html"><div class="allMarkers">
	<div class="contentBox">
		<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="community_alliance_medium_flat_black"></i>
			<span translate>ContextMenu.MarkerMenu.AllianceMarker</span>
		</div>
		<div class="default-colors clear">
            <p translate>AllMarker.Default</p>
            <ul>
                <li><div class="marker"><div class="markerColor" ng-style="{{defaultColors.kingdom.cssStyle}}"></div></div> <span translate>AllMarker.YourKingdom</span></li>
				<li ng-if="playerInAlliance"><div class="marker"><div class="markerColor" ng-style="{{defaultColors.alliance.cssStyle}}"></div></div> <span translate>AllMarker.YourAlliance</span></li>
                <li ng-if="playerInAlliance"><div class="marker"><div class="markerColor" ng-style="{{defaultColors.confederacies.cssStyle}}"></div></div> <span translate>AllMarker.Confederacies</span></li>
                <li ng-if="playerInAlliance"><div class="marker"><div class="markerColor" ng-style="{{defaultColors.nap.cssStyle}}"></div></div> <span translate>AllMarker.NonAggressionPact</span></li>
                <li><div class="marker"><div class="markerColor" ng-style="{{defaultColors.neutral.cssStyle}}"></div></div> <span translate>AllMarker.Neutral</span></li>
                <li ng-if="playerInAlliance"><div class="marker"><div class="markerColor" ng-style="{{defaultColors.enemies.cssStyle}}"></div></div> <span translate>AllMarker.Enemies</span></li>
            </ul>
        </div>
        <table ng-if="allAllianceMarkers.length > 0" class="contentBoxBody">
			<thead>
				<tr>
					<th translate>Alliance</th>
					<th translate>ContextMenu.MarkerMenu.Color</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="marker in allAllianceMarkers">
					<td><alliance-link allianceId="{{ marker.targetId }}" allianceName="{{ marker.targetName }}"></alliance-link></td>
					<td class="colorCol"><span class="markerColor" ng-style="{{ marker.colorData.cssStyle }}"></span></td>
					<td class="deleteCol">
						<i ng-if="marker.owner == typePlayer || (marker.owner == typeAlliance && hasAllianceRights)"
						   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="deleteMarkerTabAll({{ marker.id }})"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
						   tooltip tooltip-translate="Button.Delete"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

    <div ng-if="allPlayerMarkers.length == 0 && allAllianceMarkers.length == 0 && allTileMarkers[typePlayer].length == 0 && allTileMarkers[typeAlliance].length == 0">
        <span translate>AllMarker.NoMarkerSet</span>
    </div>

	<div class="contentBox" ng-if="allPlayerMarkers.length > 0">
	    <div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="community_player_medium_flat_black"></i>
	        <span translate>ContextMenu.MarkerMenu.PlayerMarker</span>
	    </div>
	    <table class="contentBoxBody">
	        <thead>
	            <tr>
	                <th translate>Player</th>
	                <th translate>ContextMenu.MarkerMenu.Color</th>
					<th class="visibleFor" translate>ContextMenu.MarkerMenu.Visible</th>
	                <th></th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr ng-repeat="marker in allPlayerMarkers">
	                <td><span player-link playerId="{{ marker.targetId }}" playerName="{{ marker.targetName }}"></span></td>
	                <td class="colorCol"><span class="markerColor" ng-style="{{ marker.colorData.cssStyle }}"></span></td>
					<td class="visibleFor">
						<span ng-if="marker.owner == typePlayer" translate>ContextMenu.MarkerMenu.Me</span>
						<span ng-if="marker.owner == typeAlliance" translate>Alliance</span>
					</td>
	                <td class="deleteCol">
						<i ng-if="marker.owner == typePlayer || (marker.owner == typeAlliance && hasAllianceRights)"
						   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="deleteMarkerTabAll({{ marker.id }})"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
						   tooltip tooltip-translate="Button.Delete"></i>
					</td>
	            </tr>
	        </tbody>
	    </table>
	</div>

	<div class="contentBox" ng-if="allTileMarkers[typePlayer].length > 0">
		<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="marker_tile_medium_flat_black"></i>
	        <span translate>ContextMenu.MarkerMenu.CoordinateMarker.Player</span>
	    </div>
	    <table class="contentBoxBody">
	        <thead>
	            <tr>
	                <th class="coordinates" translate>ContextMenu.MarkerMenu.FieldCoordinates</th>
	                <th translate>ContextMenu.MarkerMenu.Color</th>
	                <th></th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr ng-repeat="marker in allTileMarkers[typePlayer]">
	                <th class="coordinates"><div coordinates aligned="false" x="{{marker.x}}" y="{{marker.y}}"></div></th>
	                <td class="colorCol"><span class="markerColor" ng-style="{{ marker.colorData.cssStyle }}"></span></td>
					<td class="deleteCol">
						<i ng-if="marker.owner == typePlayer || (marker.owner == typeAlliance && hasAllianceRights)"
						   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="deleteMarkerTabAll({{ marker.id }})"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
						   tooltip tooltip-translate="Button.Delete"></i>
					</td>
	            </tr>
	        </tbody>
	    </table>
    </div>

	<div class="contentBox" ng-if="allTileMarkers[typeAlliance].length > 0">
		<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="marker_tile_medium_flat_black"></i>
			<span translate>ContextMenu.MarkerMenu.CoordinateMarker.Alliance</span>
		</div>
		<table class="contentBoxBody">
			<thead>
				<tr>
					<th class="coordinates" translate>ContextMenu.MarkerMenu.FieldCoordinates</th>
					<th translate>ContextMenu.MarkerMenu.Color</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="marker in allTileMarkers[typeAlliance]">
					<th class="coordinates"><div coordinates aligned="false" x="{{marker.x}}" y="{{marker.y}}"></div></th>
					<td class="colorCol"><span class="markerColor" ng-style="{{ marker.colorData.cssStyle }}"></span></td>
					<td class="deleteCol">
						<i ng-if="marker.owner == typePlayer || (marker.owner == typeAlliance && hasAllianceRights)"
						   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="deleteMarkerTabAll({{ marker.id }})"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
						   tooltip tooltip-translate="Button.Delete"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="contentBox fieldMessages">
		<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="sideMenu_igm_small_flat_black"></i>
			<span translate>ContextMenu.MarkerMenu.FieldMessages</span>
		</div>
		<table class="contentBoxBody">
			<thead ng-if="fieldMessages.length > 0">
				<tr>
					<th class="text"><i class="symbol_target_small_flat_black"></i></th>
					<th translate>ContextMenu.MarkerMenu.FieldMessages.Creator</th>
					<th translate>ContextMenu.MarkerMenu.Visible</th>
					<th translate>ContextMenu.MarkerMenu.FieldMessages.Added</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="message in fieldMessages | orderBy: '-data.timestamp'" ng-class="{'closed': message.data.isClosed, 'noDeleteOption': message.data.creatorPlayerId != playerId}">
					<th class="text">
						<div coordinates aligned="false" x="{{message.data.x}}" y="{{message.data.y}}"></div>
						{{message.data.text}}
					</th>
					<td><span player-link playerId="{{message.data.creatorPlayerId}}"></span></td>
					<td>
						<span ng-if="message.data.playerId == playerId" translate>ContextMenu.MarkerMenu.Me</span>
						<span ng-if="message.data.allianceId > 0" translate>Alliance</span>
						<span ng-if="message.data.kingdomId > 0" translate>Kingdom</span>
						<span ng-if="message.data.societyId > 0" translate>SecretSociety</span>
						<div ng-if="message.data.playerId > 0 && message.data.playerId != playerId">
							<span player-link playerId="{{message.data.playerId}}"></span>
						</div>
					</td>
					<td>
						<span tooltip tooltip-translate="ContextMenu.MarkerMenu.FieldMessages.Disappear" tooltip-data="duration: {{message.disappearIn}}">{{message.timeAgo}}</span>
					</td>
					<td class="actionsCol">
						<i ng-if="!message.data.isClosed"
						   class="hideMessage"
						   ng-class="{show_small_flat_black: !hideHover, show_small_flat_green: hideHover}"
						   clickable="toggleFieldMessageClose(message);"
						   on-pointer-over="hideHover = true" on-pointer-out="hideHover = false"
						   tooltip tooltip-translate="Button.Hide"></i>
						<i ng-if="message.data.isClosed"
						   class="showMessage"
						   ng-class="{hide_small_flat_black: !showHover, hide_small_flat_green: showHover}"
						   clickable="toggleFieldMessageClose(message);"
						   on-pointer-over="showHover = true" on-pointer-out="showHover = false"
						   tooltip tooltip-translate="Button.Show"></i>
						<i ng-if="message.data.creatorPlayerId == playerId"
						   ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="deleteFieldMessage(message);"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"
						   tooltip tooltip-translate="Button.Delete"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/markerMenu/tabs/EditMarker.html"><div class="newMarker">
	<p class="description" translate>ContextMenu.MarkerMenu.Description</p>
	<div class="horizontalLine header">
		<i class="headerImg marker_general_illustration"></i>
	</div>
	<div class="markerWrapper">
		<div ng-repeat="type in [3,1,2]"
			 class="typeSelectorWrapper {{ typeTable[type].typeName }}Marker contentBox gradient double"
			 on-pointer-over="showColors(type)"
			 on-pointer-out="hideColors(type)"
			 ng-class="{disabled: !markerAvailable(type)}">
			<div class="markerTypeName contentBoxHeader" translate options="{{ typeTable[type].typeName }}">ContextMenu.MarkerMenu.Mark_?</div>
			<div class="horizontalLine"></div>
			<!-- Override when there is an alliance marker and I don't have rights to change it -->
			<div ng-if="typeTable[type].owner == typeAlliance && !hasAllianceRights" class="typeSelector contentBoxBody">
				<div class="colors" ng-if="typeTable[type].show" tooltip tooltip-translate="ContextMenu.MarkerMenu.AllianceNoRight">
					<div class="colorButtons">
						<div class="markerColor selected" ng-style="{{ colorByIndex[typeTable[type].color].cssStyle }}"></div>
					</div>
				</div>
			</div>
			<div class="typeSelector contentBoxBody" ng-show="!(typeTable[type].owner == typeAlliance && !hasAllianceRights)"
				 ng-class="{filled: typeTable[type].show}">
				<i class="marker_splash_layout"></i>
				<div class="colors" ng-show="typeTable[type].show">
					<div class="colorButtons">
						<div clickable="setColor({{ color.index }}, {{ type }})"
							 class="markerColor" ng-style="{{ color.cssStyle }}"
							 ng-class="{selected: color.index == typeTable[type].color}"
							 ng-repeat="color in colors"></div>
					</div>
					<label ng-hide="!selectionAvailable(type)" ng-if="hasAllianceRights">
						<input type="checkbox" ng-checked="typeTable[type].owner == typeAlliance" clickable="toggleShareWithAlliance(type)"/>
						<span translate>ContextMenu.MarkerMenu.ShareWithAlliance</span>
					</label>
				</div>
				<div class="emptyMarker" ng-hide="typeTable[type].show">
					<i class="marker_{{typeTable[type].typeName}}_large_illu"></i>
				</div>
			</div>
			<div class="selectionArrow" ng-if="type == 3"></div>
		</div>
	</div>
	<div class="fieldMessage clear">
		<h5 translate>ContextMenu.MarkerMenu.FieldMarker.Add</h5>
		<div class="messageText">
			<i class="writeMessage"></i>
			<input type="text" name="fieldMessageText" maxlength="40" ng-model="fieldMessage['text']" ng-change="onFieldMessageTextChange()" placeholder="">
		</div>
		<div class="duration">
			<span translate ng-if="fieldMessage['type'] != 0">ContextMenu.MarkerMenu.FieldMarker.Duration</span>
			<div dropdown data="fieldMessageDurationDropdown" ng-if="fieldMessage['type'] != 0"></div>
			<span translate ng-if="fieldMessage['type'] == 0" class="unlimitedMessage">ContextMenu.MarkerMenu.FieldMarker.Duration.Unlimited</span>
		</div>
		<div class="horizontalLine"></div>
		<span translate>ContextMenu.MarkerMenu.Visible</span>
		<div class="visibleSelectionWrapper">
			<label>
				<input type="radio" name="fieldMessageType" value="0" ng-model="fieldMessage['type']" ng-change="onFieldMessageTypeChange()" ng-value="0">
				<span translate>ContextMenu.MarkerMenu.Me</span>
			</label>
			<label>
				<input type="radio" name="fieldMessageType" value="{{FieldMarkerPersonal.KINGDOM}}" ng-change="onFieldMessageTypeChange()" ng-model="fieldMessage['type']" ng-disabled="!playerInKingdom" ng-value="FieldMarkerPersonal.KINGDOM">
				<span translate>Kingdom</span>
			</label>
			<label>
				<input type="radio" name="fieldMessageType" value="{{FieldMarkerPersonal.ALLIANCE}}" ng-change="onFieldMessageTypeChange()" ng-model="fieldMessage['type']" ng-disabled="!playerInAlliance" ng-value="FieldMarkerPersonal.ALLIANCE">
				<span translate>Alliance</span>
			</label>
			<label ng-show="secretSocietyDropdown.selected">
				<input type="radio" name="fieldMessageType" value="{{FieldMarkerPersonal.SOCIETY}}" ng-change="onFieldMessageTypeChange()" ng-model="fieldMessage['type']" ng-value="FieldMarkerPersonal.SOCIETY">
				<span translate>SecretSociety</span>
				<div dropdown data="secretSocietyDropdown"></div>
			</label>
			<label>
				<input type="radio" name="fieldMessageType" value="{{FieldMarkerPersonal.PLAYER}}" ng-change="onFieldMessageTypeChange()" ng-model="fieldMessage['type']" ng-value="FieldMarkerPersonal.PLAYER">
				<span translate>ContextMenu.MarkerMenu.FieldMarker.Player</span>
				<serverautocomplete class="name" vertical-align="above" autocompletedata="{{playerSearch.autocompleteParam}}" autocompletecb="setSearchName" on-focus="onPlayerSearchFocus" ng-model="playerSearch.name"></serverautocomplete>
			</label>
		</div>
		<span class="error" ng-if="error">{{error}}</span>
	</div>
</div>
<div class="buttonWrapper">
	<button ng-class="{disabled: !markerChanged}" class="saveMarkers" clickable="saveMarkers()">
		<span translate>Button.Save</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/notEnoughGold/notEnoughGold.html"><div class="notEnoughGold" ng-controller="notEnoughGoldCtrl">
	<div class="packageDescription" translate>Payment.NotEnoughGold.Description</div>
	<div ng-if="shopAvailable">
		<div class="packageWrapper">
			<div class="package clickableContainer">
				<img ng-src="{{package.product_image_url}}" />
				<div class="unitsWrapper">
					<div class="units">{{package.units}}</div>
				</div>
				<div class="priceWrapper">
					<div class="currency">{{package.currency}}</div>
					<div class="price">{{package.price}}</div>
				</div>
				<div class="verticalLine double"></div>
			</div>
		</div>
		<div class="packageDescription" translate>Payment.NotEnoughGold.DescriptionOtherPackages</div>
		<div class="shopLink">
			<a clickable="openShop()" translate>Payment.NotEnoughGold.ChooseOtherPackage</a>
		</div>
	</div>
	<div ng-if="!shopEnabled">
		<span translate>Payment.ShopIsDisabled</span>
	</div>
	<div ng-if="shopEnabled && !shopAvailable">
		<span translate>Payment.ShopIsNotAvailable</span>
	</div>
	<div class="horizontalLine"></div>

	<button class="cancel" clickable="closeWindow('notEnoughGold');"><span translate>Button.Cancel</span></button>
	<button ng-if="shopAvailable" class="buy" clickable="openShop({{package.product_id}})">
		<span translate>Payment.NotEnoughGold.BuyGold</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/notEnoughSitterRights/notEnoughSitterRights.html"><div class="notEnoughSitterRights" ng-controller="notEnoughSitterRightsCtrl">
	<div translate>Sitter.NotEnoughRightsTooltip</div>
	<button class="cancel" clickable="closeWindow('notEnoughSitterRights');"><span translate>Button.Cancel</span></button>
</div></script>
<script type="text/ng-template" id="tpl/npcTrader/finishNowTooltip.html"><div class="finishNowTooltip" ng-controller="finishNowCtrl">
	<div ng-if="!isWorldWonder && (inBuilding.length>0 || inTraining.length>0 || inDestruction.length>0 || inResearch.length>0)">
		<h3>
			<span translate >FinishNow.FinishFollowingOrders</span><span ng-if="price == 0">:</span>
			<span class="price" ng-if="price > 0 || forceGoldUsage"><i class="unit_gold_small_illu"></i>{{price}}:</span>
			<span class="price" ng-if="price == -1 && !forceGoldUsage"><i class="cardGame_prizePremium_small_illu"></i><span>1:</span></span>
		</h3>
		<div class="horizontalLine"></div>

		<div ng-repeat="build in inBuilding track by $index">
			<span ng-if="!finishNowQueueType" class="description" translate>FinishNow.Build</span>
			<span translate options="{{build.buildingType}}">Building_?</span>
			<span class="level" translate data="lvl:{{buildingsByLocation[build.locationId].data.lvl + 1}}">Building.Level</span>
		</div>
		<div ng-repeat="destruction in inDestruction track by $index">
			<span ng-if="::destruction.isRubble != 1" class="description" translate>FinishNow.Demolish</span>
			<span ng-if="::destruction.isRubble == 1" class="description" translate>FinishNow.Dismantle</span>
			<span translate options="{{destruction.buildingType}}">Building_?</span>
		</div>
		<div ng-repeat="research in inResearch track by $index">
			<span ng-if="!finishNowBuildingType" class="description" translate>FinishNow.Research</span>
			<span translate options="{{research.unitType}}">Troop_?</span>
		</div>
		<div ng-repeat="training in inTraining track by $index">
			<span ng-if="!finishNowBuildingType" class="description" translate>FinishNow.Training</span>
			<span translate options="{{training.unitType}}">Troop_?</span>
			<span class="level" translate data="lvl:{{training.researchLevel}}">Building.Level</span>
		</div>
		<div ng-if="inMasterBuilder">
			<span ng-if="finishNowVillageId" class="description" translate>FinishNow.MasterBuilder</span>
			<span translate options="{{inMasterBuilder.buildingType}}">Building_?</span>
			<span ng-if="inMasterBuilder.level" class="level" translate data="lvl:{{inMasterBuilder.level + 1}}">Building.Level</span>
			<span ng-if="inMasterBuilder.enoughResources == false" class="negative" translate>FinishNow.MasterBuilder.NotEnoughResources</span>
		</div>
	</div>
	<div ng-if="isWorldWonder" translate>Error.NotAvailableInWW</div>
	<div ng-if="!isWorldWonder && hasInvalidBuilding" translate>FinishNow.CantInstantComplete</div>
	<div ng-if="!isWorldWonder && !hasInvalidBuilding && inBuilding.length == 0 && inTraining.length == 0 && inDestruction.length == 0 && inResearch.length == 0" translate>FinishNow.NothingToComplete</div>
	<div ng-if="!isWorldWonder && premiumOptionMenu.options.instantCompletion && !freeSlots && enoughRes === false">
		<div class="horizontalLine"></div>
		<div ng-if="!enoughAfterNPCTrade" translate>FinishNow.NotEnoughResources</div>
		<div ng-if="enoughAfterNPCTrade" translate>FinishNow.NeedsNPCTrader</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/npcTrader/npcTrader.html"><div ng-controller="npcTraderCtrl" class="npcTraderContent">
	<div ng-include src="'tpl/building/marketplace/tabs/NpcTrade.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/payment/payment.html"><div ng-controller="paymentCtrl">
	<div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/payment/overlay/sendEmail.html"><div class="control-group">
	<label class="control-label" for="friendName" translate>InviteFriend.Email.FriendName</label>

	<div class="controls">
		<input type="text" id="friendName" placeholder="{{placeholder.friendName}}" ng-model="input.friendName" ng-change="checkInput()" auto-focus />
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="email" translate>InviteFriend.Email.Email</label>

	<div class="controls">
		<input type="text" id="email" placeholder="{{placeholder.email}}" ng-model="input.email" ng-change="checkInput()" />
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="ownName" translate>InviteFriend.Email.OwnName</label>

	<div class="controls">
		<input type="text" id="ownName" placeholder="{{placeholder.ownName}}" ng-model="input.ownName" ng-change="checkInput()" />
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="message" translate>InviteFriend.Email.Message</label>

	<div class="controls">
		<textarea id="message" placeholder="{{placeholder.message}}" ng-model="input.message" ng-change="checkInput()"></textarea>
	</div>
</div>
<div class="control-group">
	<div class="controls clear">
		<span class="error" ng-if="error">{{error}}</span>
		<button type="submit" clickable="invite()" ng-class="{disabled: !valid}">
			<span translate>InviteFriend.Email.InviteBtn</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/payment/partials/cropProductionBonus.html"><p data="bonus: {{feature.productionBonusValue}}" translate>Payment.SpendGold.CropProductionBonus.Header</p>
<p data="bonus: {{feature.productionBonusValue}}" translate>Payment.SpendGold.CropProductionBonus.Description</p></script>
<script type="text/ng-template" id="tpl/payment/partials/others.html"><div class="feature" ng-repeat="(name, iconClass) in {'BuildMaster': 'buildingMasterSlot', 'FinishNow': 'finishNow', 'ExchangeOffice': 'exchangeOffice', 'InstantTrader': 'traderArriveInstantly', 'MoreTrader': 'traderSlot', 'NPCTrader': 'npcTrader', 'TributeTreasures': 'tributeAndTreasuresArriveInstantly'}">
	<i class="otherFeatures premium_{{iconClass}}_medium_illu"></i>
	<div class="information">
		<span class="header" translate options="{{name}}">Payment.SpendGold.Others_?.Header</span>
		<span translate options="{{name}}">Payment.SpendGold.Others_?.Description</span>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/payment/partials/othersIcons.html"><i ng-repeat="(id, iconClass) in {1: 'buildingMasterSlot', 2: 'finishNow', 3: 'exchangeOffice', 4: 'traderArriveInstantly', 5: 'traderSlot', 6: 'npcTrader', 7: 'tributeAndTreasuresArriveInstantly'}"
   class="otherFeatures premium_{{iconClass}}_medium_illu"></i></script>
<script type="text/ng-template" id="tpl/payment/partials/plusAccount.html"><p translate>Payment.SpendGold.PlusAccount.Header</p>

<div class="advantage" ng-repeat="name in ['Storage', 'FarmList', 'Smithy', 'Party', 'TradeRoute']">
	<h5 options="{{name}}" translate>Payment.SpendGold.PlusAccount_?.Header</h5>
	<div options="{{name}}" translate>Payment.SpendGold.PlusAccount_?.Description</div>
</div></script>
<script type="text/ng-template" id="tpl/payment/partials/productionBonus.html"><p data="bonus: {{feature.productionBonusValue}}" translate>Payment.SpendGold.ProductionBonus.Header</p>
<p data="bonus: {{feature.productionBonusValue}}" translate>Payment.SpendGold.ProductionBonus.Description</p></script>
<script type="text/ng-template" id="tpl/payment/partials/rewardInfoTooltip.html"><div class="rewardTooltip clear">
	<p translate options="{{BONUS_CONSTANT_MAP[i]}}">InviteFriend.InvitationOverview.Bonus.?</p>
	<span class="server"><span translate>InviteFriend.InvitationOverview.Server</span> {{invitation.bonuses[i].worldName}}</span>
	<span class="reward"><span translate>InviteFriend.InvitationOverview.Reward</span> <i class="unit_gold_small_illu"></i> {{goldCost[BONUS_CONSTANT_MAP[i]]}}</span>
</div></script>
<script type="text/ng-template" id="tpl/payment/partials/starterPackage.html"><div ng-if="activeFeature.version == PremiumFeature.STARTER_PACKAGE_VERSION_1">
    <p translate>
        Payment.SpendGold.StarterPackage.Header
    </p>
    <div class="advantages">
        <h5 translate>Payment.SpendGold.Advantages</h5>
        <div translate data="x: {{activeFeature.duration / 86400}}">
            Payment.SpendGold.StarterPackage.DaysOfPlusAccount
        </div>
        <div translate data="x: {{activeFeature.duration / 86400}}">
            Payment.SpendGold.StarterPackage.DaysOfProductionBonus
        </div>
        <div translate data="x: {{activeFeature.duration / 86400}}">
            Payment.SpendGold.StarterPackage.DaysOfCropProductionBonus
        </div>
        <div>6000 <span translate>Silver</span></div>
    </div>
    <div class="bonus">
        <h5 translate>Payment.SpendGold.Bonus</h5>
        <div>1x <span translate options="{{HeroItem.TYPE_BOOK}}">Hero.Item_?</span></div>
        <div>20x <span translate options="{{HeroItem.TYPE_OINTMENT}}">Hero.Item_?</span></div>
        <div>20x <span translate options="{{HeroItem.TYPE_BANDAGE_25}}">Hero.Item_?</span></div>
    </div>
</div>
<div ng-if="activeFeature.version == PremiumFeature.STARTER_PACKAGE_VERSION_2">
    <p translate>
        Payment.SpendGold.StarterPackage.Header.Version2
    </p>
    <div class="advantages">
        <h5 translate>Payment.SpendGold.Advantages.Version2</h5>
        <div>4x <span translate options="{{HeroItem.TYPE_NPC_TRADER}}">Hero.Item_?</span></div>
        <div>5x <span translate options="{{HeroItem.TYPE_FINISH_IMMEDIATELY}}">Hero.Item_?</span></div>
        <div>6000 <span translate>Silver</span></div>
    </div>
    <div class="bonus">
        <h5 translate>Payment.SpendGold.Bonus.Version2</h5>
        <div>1x <span translate options="{{HeroItem.TYPE_BOOK}}">Hero.Item_?</span></div>
        <div>20x <span translate options="{{HeroItem.TYPE_OINTMENT}}">Hero.Item_?</span></div>
        <div>20x <span translate options="{{HeroItem.TYPE_BANDAGE_25}}">Hero.Item_?</span></div>
    </div>
</div>

<div ng-show="!activeFeature.active">
	<div data="date:{{activeFeature.disabledAt}}" ng-show="activeFeature.getDisableDurationInDays() > 0" translate>Payment.SpendGold.StarterPackage.ExpiredAt</div>
	<div class="durationLastDay" data="date:{{activeFeature.disabledAt}}" ng-show="activeFeature.getDisableDurationInDays() == 0" translate>Payment.SpendGold.StarterPackage.ExpiredIn</div>
	<div class="noLongerAvailable" data="date:{{activeFeature.disabledAt}}" ng-show="activeFeature.getDisableDurationInDays() < 0" translate>Payment.SpendGold.StarterPackage.ExpiredAlready</div>
</div></script>
<script type="text/ng-template" id="tpl/payment/tabs/InviteFriend.html"><div ng-controller="inviteFriendCtrl" class="inviteFriend">
	<div class="contentBox">
		<div class="contentBoxBody">
			<div class="featureList">
				<div class="clickableContainer" clickable="changeActiveTab('invite')" ng-class="{active: selectedTab == 'invite'}">
					<h5 translate>InviteFriend.InviteFriend.TabHeader</h5>

					<div class="horizontalLine double"></div>
					<div class="description" translate>InviteFriend.InviteFriend.TabDescription</div>
					<i class="inviteFriend_invite_large_illu"></i>
					<i class="arrow" ng-show="selectedTab == 'invite'"></i>
				</div>
				<div class="clickableContainer" clickable="changeActiveTab('overview')" ng-class="{active: selectedTab == 'overview'}">
					<h5 translate>InviteFriend.InvitationOverview.TabHeader</h5>

					<div class="horizontalLine double"></div>
					<div class="description" translate>InviteFriend.InvitationOverview.TabDescription</div>
					<i class="inviteFriend_invitationOverview_large_illu"></i>
					<i class="arrow" ng-show="selectedTab == 'overview'"></i>
					<i class="symbol_star_small_illu" ng-show="bonusesToCollect > 0"></i>
				</div>
				<div class="contentBox gradient giftBox">
					<div class="contentBoxHeader headerWithArrowEndings">
						<div class="content" translate>InviteFriend.Gift</div>
					</div>
					<div class="contentBoxBody">
						<div class="spacer"></div>
						<i class="inviteFriend_invitationGift_large_illu"></i>
						<span translate>InviteFriend.Gift.Description</span>
					</div>
				</div>
			</div>
			<div class="featureInformation contentBox" ng-show="selectedTab == 'invite'" scrollable>
				<div class="contentBox gradient receive">
					<div class="contentBoxHeader">
						<span class="content" translate>InviteFriend.InviteFriend.Header</span>
					</div>
					<div class="contentBoxBody">
						<p translate>InviteFriend.InviteFriend.Description</p>
						<div class="reward">
							<i class="rewardIcon inviteFriend_secondVillage_small_flat_black"></i>
							<span class="text" translate data="gold: {{goldCost['rewardSecondVillage']}}">InviteFriend.InviteFriend.SecondVillage</span>
						</div>
						<div class="reward">
							<i class="rewardIcon inviteFriend_thirdVillage_medium_flat_black"></i>
							<span class="text" translate data="gold: {{goldCost['rewardThirdVillage']}}">InviteFriend.InviteFriend.ThirdVillage</span>
						</div>
						<div class="reward">
							<i class="rewardIcon inviteFriend_firstPayment_small_flat_black"></i>
							<span class="text" translate data="gold: {{goldCost['rewardFirstPayment']}}">InviteFriend.InviteFriend.FirstPayment</span>
						</div>
						<div class="reward">
							<i class="rewardIcon inviteFriend_prestigeCup_small_flat_black"></i>
							<span class="text" translate data="gold: {{goldCost['reward1000PrestigeReached']}}">InviteFriend.InviteFriend.Prestige</span>
						</div>
					</div>
				</div>
				<div class="contentBox invite email">
					<div class="contentBox gradient">
						<div class="contentBoxBody">
							<p class="header" translate>InviteFriend.InviteFriend.InviteByEmail</p>
							<span translate>InviteFriend.InviteFriend.InviteByEmail.Info</span>
						</div>
					</div>
					<div class="inviteButton">
						<button ng-click="openSendEmailOverlay()">
							<span translate>InviteFriend.InviteFriend.InviteByEmail.Button</span>
						</button>
					</div>
				</div>
				<div class="contentBox invite">
					<div class="contentBox gradient">
						<div class="contentBoxBody">
							<p class="header" translate>InviteFriend.InviteFriend.InviteByLink</p>
							<span><a href="{{refLink}}" target="_blank" translate>InviteFriend.InviteFriend.ReferralLink</a></span>
						</div>
					</div>
					<div class="inviteButton">
						<button ng-click="copyLink()">
							<span translate>InviteFriend.InviteFriend.InviteByLink.Button</span>
						</button>
					</div>
				</div>
			</div>
			<div class="featureInformation contentBox invitations" ng-show="selectedTab == 'overview'">
				<div class="contentBox gradient accepted">
					<div class="contentBoxHeader">
						<span class="content" translate>InviteFriend.InvitationOverview.AcceptedInvitations</span> ({{invitations.accepted.length}})
					</div>

					<div scrollable class="contentBoxBody">
						<table class="transparent" ng-show="invitations.accepted.length > 0">
							<thead>
								<tr>
									<th translate>InviteFriend.InvitationOverview.AvatarName</th>
									<th><i class="rewardIcon inviteFriend_secondVillage_small_flat_black"></i></th>
									<th><i class="rewardIcon inviteFriend_thirdVillage_medium_flat_black"></i></th>
									<th><i class="rewardIcon inviteFriend_firstPayment_small_flat_black"></i></th>
									<th><i class="inviteFriend_prestigeCup_small_flat_black"></i></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="invitation in invitations.accepted | orderBy:'collectibleAmount':true">
									<td>{{invitation.invitedAccountName}} <span class="rightBorder"></span></td>
									<td ng-repeat="i in []|range:0:3" tooltip tooltip-placement="above" tooltip-url="tpl/payment/partials/rewardInfoTooltip.html">
										<i class="unit_gold_small_illu" ng-class="{
											notGranted: invitation.bonuses[i].state == BONUS_STATE.NOT_GRANTED,
											granted: invitation.bonuses[i].state == BONUS_STATE.GRANTED,
											collected: invitation.bonuses[i].state == BONUS_STATE.COLLECTED
										}"></i>
										<i ng-show="invitation.bonuses[i].state == BONUS_STATE.COLLECTED" class="action_check_small_flat_green"></i>
										<span class="rightBorder"></span>
									</td>
									<td>
										<span ng-if="invitation.status === 1" tooltip tooltip-translate="InviteFriend.InvitationOverview.NotActivated.Tooltip" class="notActivated">
											<span translate>InviteFriend.InvitationOverview.NotActivated</span>
										</span>
										<button ng-if="invitation.status === 2" ng-class="{disabled: !invitation.collectible}" clickable="collectBonus(invitation)"><span translate>InviteFriend.InvitationOverview.Collect</span></button>
									</td>
								</tr>
							</tbody>
						</table>
						<p translate ng-show="invitations.accepted.length === 0">InviteFriend.InvitationOverview.NoAccepted</p>
					</div>
				</div>
				<div class="contentBox gradient open">
					<div class="contentBoxHeader">
						<span class="content" translate>InviteFriend.InvitationOverview.OpenInvitations</span> ({{invitations.open.length}})
					</div>

					<div scrollable class="contentBoxBody">
						<table class="transparent" ng-show="invitations.open.length > 0">
							<tbody>
								<tr ng-repeat="invitation in invitations.open">
									<td>{{invitation.invitedEmail}}<span class="rightBorder"></span></td>
									<td><span i18ndt="{{invitation.invitingTime}}" format="mediumDate"></span></td>
								</tr>
							</tbody>
						</table>
						<p translate ng-show="invitations.open.length === 0">InviteFriend.InvitationOverview.NoOpen</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/payment/tabs/PaymentShop.html"><div ng-if="player.data.deletionTime > 0" translate>Feature.NotPossibleInDeletion</div>
<div ng-include src="'tpl/activation/activationNeeded.html'" ng-if="player.data.isActivated != 1 && player.data.deletionTime == 0"></div>
<div ng-controller="paymentShopCtrl" ng-if="player.data.isActivated == 1 && player.data.deletionTime == 0">
	<div ng-if="shopEnabled">
		<div ng-show="iFrame != null">
			<iframe ng-src="{{iFrame}}" width="820" height="580" frameBorder="0">
			</iframe>
		</div>
		<div ng-show="iFrame == null">
			<span translate>Payment.ShopIsNotAvailable</span>
		</div>
	</div>
	<div ng-if="!shopEnabled">
		<span translate>Payment.ShopIsDisabled</span>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/payment/tabs/PremiumFeatures.html"><div ng-controller="premiumFeaturesCtrl" class="premiumFeatures spendGold">
	<div class="contentBox">
		<div class="contentBoxBody">
			<div class="featureList">
				<div ng-repeat="feature in featureList | orderBy:'order'" ng-show="!feature.isDisabled || feature.active" class="clickableContainer" ng-class="{active: activeFeature.name == feature.name, bookable: feature.canActivate, booked: feature.active}" clickable="changeActiveFeature(feature)">
					<h5 translate options="{{feature.name}}">Payment.SpendGold.Header_?</h5>

					<div class="horizontalLine double"></div>
					<div class="status" ng-if="feature.canActivate">
						<span class="inactive" ng-show="!feature.active" translate>Payment.SpendGold.Status.Inactive</span>
						<span class="active" ng-show="feature.active && feature.endTime === false && !feature.bought" translate>Payment.SpendGold.Status.Active</span>
						<span class="active" ng-show="feature.active && feature.endTime === false && feature.bought" translate>Payment.SpendGold.Status.Bought</span>
						<span class="moreThanOneDay" data="x: {{feature.getDays()}}" translate ng-show="feature.active && feature.endTime !== false && feature.getDays() > 1">Payment.SpendGold.DurationInDays</span>
						<span class="lastDay" ng-show="feature.active && feature.endTime !== false && feature.getDays() <= 1 && !feature.wholeGameRound.booked" countdown="{{feature.endTime}}"></span>
						<span class="moreThanOneDay" ng-show="feature.active && feature.endTime !== false && feature.wholeGameRound.booked" translate>Payment.SpendGold.Status.ActivatedForWholeRound</span>
					</div>
					<i ng-if="!feature.iconsPartial"
					   class="premiumFeature premium_{{feature.name}}_large_illu"></i>
					<div ng-if="feature.iconsPartial" ng-include="feature.iconsPartial"></div>
					<i class="action_check_medium_flat_white" ng-show="feature.active"></i>
					<i class="arrow" ng-show="activeFeature.name == feature.name"></i>
				</div>
			</div>
			<div class="featureInformation contentBox" ng-repeat="feature in featureList" ng-show="feature.name == activeFeature.name">
				<div class="contentBoxHeader headerWithIcon arrowDirectionDown">
					<i class="premiumFeature premium_{{feature.name}}_medium_illu"
					   ng-class="{premium_furtherFeatures_medium_illu: feature.name == 'others'}"></i>
					<span class="content" translate options="{{feature.name}}">Payment.SpendGold.Header_?</span>
				</div>

				<div scrollable class="contentBoxBody" ng-class="{withoutFooter: !feature.canActivate, bookableForWholeGameRound: feature.wholeGameRound.bookable, bookedWholeGameRound: feature.wholeGameRound.booked}">
					<div ng-if="feature.name == activeFeature.name" class="{{feature.name}}" ng-include="feature.partial"></div>
				</div>
				<div ng-if="feature.canActivate && !feature.wholeGameRound.bookable" class="contentBoxFooter">
					<div class="autoExtend">
						<div ng-show="feature.autoExtendFlag !== false">
							<h5 translate>Payment.SpendGold.AutoExtend</h5>
							<switch switch-name1="No" switch-name2="Yes" switch-callback="feature.saveAutoExtend" switch-disabled="!feature.active" switch-model="feature.autoExtend"></switch>
						</div>
					</div>
					<div class="verticalLine"></div>
					<div class="book">
						<span ng-if="feature.showDurationFlag" class="duration"><span translate data="x: {{feature.duration / 86400}}">Payment.SpendGold.DurationInDaysShort</span></span>
						<button ng-show="feature.autoExtendFlag === false || (feature.autoExtendFlag !== false && !feature.active)"
								ng-class="{disabled: (feature.autoExtendFlag === false && feature.active) || feature.isDisabled}"
								class="premium" premium-feature="{{feature.name}}"
								price="{{feature.price}}"><span translate>Payment.SpendGold.Activate</span></button>
						<button ng-show="feature.autoExtendFlag !== false && feature.active"
								ng-class="{disabled: feature.isDisabled}"
								class="premium" premium-feature="{{feature.name}}"
								price="{{feature.price}}"><span translate>Payment.SpendGold.RenewBonus</span></button>
					</div>
				</div>
				<div ng-if="feature.canActivate && feature.wholeGameRound.bookable && !feature.wholeGameRound.booked" class="contentBoxFooter bookableForWholeGameRound">
					<div class="book">
						<span ng-if="feature.showDurationFlag" class="duration"><span translate data="x: {{feature.duration / 86400}}">Payment.SpendGold.DurationInDaysShort</span></span>
						<button ng-show="feature.autoExtendFlag === false || (feature.autoExtendFlag !== false && !feature.active)"
								ng-class="{disabled: (feature.autoExtendFlag === false && feature.active) || feature.isDisabled}"
								class="premium" premium-feature="{{feature.name}}"
								price="{{feature.price}}"><span translate>Payment.SpendGold.Activate</span></button>
						<button ng-show="feature.autoExtendFlag !== false && feature.active"
								ng-class="{disabled: feature.isDisabled}"
								class="premium" premium-feature="{{feature.name}}"
								price="{{feature.price}}"><span translate>Payment.SpendGold.RenewBonus</span></button>
						<div class="autoExtend">
							<div ng-show="feature.autoExtendFlag !== false">
								<h5 translate>Payment.SpendGold.AutoExtend</h5>
								<switch class="autoExtendSwitch" switch-name1="No" switch-name2="Yes" switch-callback="feature.saveAutoExtend" switch-disabled="!feature.active" switch-model="feature.autoExtend"></switch>
							</div>
						</div>
					</div>
					<div class="verticalLine"></div>
					<div class="book">
						<span class="duration"><span translate>Payment.SpendGold.DurationWholeGameRound</span></span>
						<button ng-class="{disabled: (feature.wholeGameRound.booked) || feature.isDisabled}"
								class="premium" premium-feature="{{feature.name}}" premium-callback-param="true"
								price="{{feature.wholeGameRound.price}}"><span translate>Payment.SpendGold.Activate</span></button>
						<div class="saveMoreThanText" ng-if="feature.price < feature.wholeGameRound.price" translate>Payment.SpendGold.WholeGameRound.SaveMoreThan</div>
					</div>
				</div>
				<div ng-if="feature.canActivate && feature.wholeGameRound.bookable && feature.wholeGameRound.booked" class="contentBoxFooter bookableForWholeGameRound bookedWholeGameRound">
					<span translate>Payment.SpendGold.ActivatedForWholeRound</span>
					<i class="action_check_medium_flat_white"></i>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/playerLocked/playerLocked.html"><div class="playerBanError" scrollable>
	<div class="playerLocked" ng-controller="playerLockedCtrl">
		<div class="reason" ng-repeat="reason in reasons">
			<div class="reasonTitle">
				<div class="clickableContainer" clickable="expandReason($index)">
					<i ng-class="{symbol_arrowTo_small_flat_green: reason.expanded,
								  symbol_arrowDown_small_flat_black: !reason.expanded}"></i>
				</div>
				<div ng-if="punishment != PlayerPunishment.TYPE_ISOLATED" class="titleText" translate options="{{reason.type}}">PlayerLocked.description.intro.headline_?</div>
				<div ng-if="punishment == PlayerPunishment.TYPE_ISOLATED" class="titleText" translate>PlayerIsolated.description.intro.headline</div>
			</div>
			<div class="reasonDescription" ng-show="reason.expanded">
				<p translate data="avatarName: {{playerAvatarName}}">PlayerLocked.description.greeting</p>
				<div ng-if="punishment == PlayerPunishment.TYPE_ISOLATED">
					<p translate>PlayerIsolated.description.intro.reason</p>
					<p translate>PlayerLocked.description.rulesReferring</p>
					<div class="rulesLink"><a clickable="openOverlay('gameRulesOverlay')" translate>HelpMenu.GameRules</a></div>
					<div class="multiHunter">
						<p translate>PlayerLocked.description.ContactMultiHunter</p>
						<a class="clickableContainer" clickable="openHelpCenter();">
							<span translate>HelpMenu.HelpCenter</span>
							<div class="decoration"><i class="externalLink"></i></div>
						</a>
					</div>
				</div>

				<div ng-if="punishment != PlayerPunishment.TYPE_ISOLATED && reason.type != PlayerPunishment.STRIKE_REASON_PAYMENT">
					<p translate options="{{reason.type}}">PlayerLocked.description.intro.reason_?</p>
					<p ng-if="punishment == 'playerBanned'" translate>PlayerBanned.description.intro</p>
					<p ng-if="suspensionTime != 0"><span translate class="error" data="timeFinish: {{suspensionTime}}">PlayerLocked.SuspensionTime.Description</span></p>
					<p translate>PlayerLocked.description.rulesReferring</p>
					<div class="rulesLink"><a clickable="openOverlay('gameRulesOverlay')" translate>HelpMenu.GameRules</a></div>
					<div class="multiHunter">
						<p translate>PlayerLocked.description.ContactMultiHunter</p>
						<a class="clickableContainer" clickable="openHelpCenter();" ng-class="{disabled: isSitter}"
						   tooltip tooltip-translate="Sitter.Tooltip.Disabled" tooltip-show="{{isSitter}}">
							<span translate>HelpMenu.HelpCenter</span>
							<div class="decoration"><i class="action_openExternal_small_flat_white"></i></div>
						</a>
					</div>
				</div>

				<div ng-if="punishment != PlayerPunishment.TYPE_ISOLATED && reason.type == PlayerPunishment.STRIKE_REASON_PAYMENT">
					<div ng-if="paymentDetails.ordersCount > 0 && paymentDetails.clickAndBuyOrders < paymentDetails.ordersCount">
						<p>
							<span translate>PlayerLocked.description.intro.reason_7.general1</span>
							{{paymentDetails.providers}}
							<span translate>PlayerLocked.description.intro.reason_7.general2</span>
						</p>
						<div class="transferDetails">
							<div>
								<p class="transferDetailsHeader" translate>PlayerLocked.description.payment.pleaseSend</p>
								<div ng-repeat="order in paymentDetails.orders">
									<span translate data="packetPrice:{{order.price}},
				 									 provider:{{order.provider}}">PlayerLocked.description.payment.order.price</span> <br />
									<span translate data="fees:{{order.fee}}">PlayerLocked.description.payment.order.fee</span>
								</div>
								<br />
								<p data="total:{{paymentDetails.total | number:2}},
										 instanceId: {{paymentDetails.instanceId}},
										 userid: {{paymentDetails.userId}}" translate>PlayerLocked.description.payment.total</p>
							</div>
							<div>
								<p class="transferDetailsHeader" translate>PlayerLocked.description.payment.sendTo</p>
								<p translate>PlayerLocked.description.payment.sendAddress</p>
							</div>
						</div>
					</div>
					<div ng-if="paymentDetails.ordersCount == 0">
						<p translate>PlayerLocked.description.intro.reason_7.noOrders</p>
						<p translate>PlayerLocked.description.keepInMind.noOrders</p>
						<ul>
							<li translate>PlayerLocked.description.keepInMind.noOrders1</li>
							<li translate>PlayerLocked.description.keepInMind.noOrders2</li>
							<li translate>PlayerLocked.description.keepInMind.noOrders3</li>
						</ul>
					</div>
					<p ng-if="paymentDetails.clickAndBuyOrders > 0" data="provider:{{paymentDetails.providers}}" translate>PlayerLocked.description.intro.reason_7.clickandbuy</p>
				</div>

				<p translate>PlayerLocked.description.closing</p>
			</div>
		</div>
		<div class="contentBox">
			<div class="contentBoxBody">
				<div class="keepInMind">
					<p translate>PlayerLocked.description.keepInMind</p>
					<ul>
						<li translate>PlayerLocked.description.keepInMind1</li>
						<li translate>PlayerLocked.description.keepInMind2</li>
						<li translate>PlayerLocked.description.keepInMind3</li>
						<li translate>PlayerLocked.description.keepInMind4</li>
						<li translate>PlayerLocked.description.keepInMind5</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/productionOverview/productionOverview.html"><div class="productionOverview" ng-controller="productionOverviewCtrl">
    <div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/productionOverview/partials/Resource.html"><div class="productionContainer">
	<div class="productionPerHour">
		<table>
			<thead>
				<tr>
					<th translate>ProductionOverview.ResourceField</th>
					<th translate>ProductionOverview.Production</th>
					<th translate>ProductionOverview.Bonus</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="field in resourceFields">
					<td>
						<span translate options="{{field.type}}">Building_?</span>
						<span data="lvl: {{field.level}}" translate>Building.Level</span>
					</td>
					<td class="numberCell">{{field.value | bidiNumber:"":false:false}}</td>
					<td class="numberCell">{{field.bonusValue | bidiNumber:"":false:false}}</td>
				</tr>
				<tr class="sumCell">
					<td translate>ProductionOverview.SumProduction</td>
					<td class="numberCell">{{sumProduction | bidiNumber:"":false:false}}</td>
					<td class="numberCell">{{sumBonusProduction | bidiNumber:"":false:false}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="productionBoost contentBox">
		<h6 class="contentBoxHeader headerTrapezoidal">
			<div class="content" translate>
				ProductionOverview.ProductionBonus
			</div>
		</h6>
		<div class="contentBoxBody">
			<div class="arrowContainer arrowDirectionTo" ng-repeat="bonus in buildingBoni">
				<span class="arrowInside">
					<span translate options="{{bonus.type}}">Building_?</span><br>
					<span translate data="lvl: {{bonus.level}}">Building.Level</span>
				</span>
				<span class="arrowOutside">
					{{bonus.value * 100 | bidiNumber:"percent":false:false}}
				</span>
			</div>
			<div class="arrowContainer arrowDirectionTo">
				<span class="arrowInside">
					<span translate>ProductionOverview.Bonus.Oasis</span><br>
					<span ng-if="oasis.number > 0">{{oasis.number | bidiNumber:"times":false:false}}</span>
					<span translate ng-if="oasis.number == 0">ProductionOverview.Bonus.NoOasis</span>
				</span>
				<span class="arrowOutside">
					{{oasis.boni * 100 | bidiNumber:"percent":false:false}}
				</span>
			</div>
			<div class="bonusSum">
				<span translate>ProductionOverview.SumBonus</span>
				<div>{{sumBonus * 100 | number:0 | bidiNumber:"percent":false:false}}</div>
			</div>
			<div class="indicationArrow"></div>
		</div>
	</div>
</div>
<div class="contentBox totalProduction">
	<div class="contentBoxBody">
		<div class="contentBox calculation transparent">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content" translate>
					ProductionOverview.TotalProduction
				</div>
			</h6>
			<div class="contentBoxBody">
				<table class="rowOnly">
					<tbody>
						<tr class="production">
							<td translate>ProductionOverview.Production</td>
							<td class="numberCell">{{sumProduction | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="bonus">
							<td translate>ProductionOverview.Bonus</td>
							<td class="numberCell">{{sumBonusProduction | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="treasureProduction" ng-if="(player.data.isKing || player.isDuke) && currentResourceType == resourceType.crop">
							<td translate>ProductionOverview.TreasureProduction</td>
							<td class="numberCell">{{treasureProduction | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="heroProduction">
							<td translate>ProductionOverview.HeroProduction</td>
							<td class="numberCell">{{heroProduction | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="oasisTroopProduction">
							<td translate>ProductionOverview.OasisTroopProduction</td>
							<td class="numberCell">{{oasisTroopProduction | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="interimBalance">
							<td translate>ProductionOverview.InterimBalance</td>
							<td class="numberCell">{{interimBalance | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="goldBonusProduction">
							<td data="percentage: {{productionBonusValue | bidiNumber:'percent':true:false}}" translate>ProductionOverview.GoldBonusProduction</td>
							<td class="numberCell">{{goldBonus | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="kingPercentage" ng-if="kingPercentage">
							<td data="percentage: {{kingPercentage | bidiNumber:'':false:false}}" translate>ProductionOverview.KingTaxes</td>
							<td class="numberCell">{{kingBonus | bidiNumber:"":false:false}}</td>
						</tr>
						<tr class="total">
							<td class="" translate>ProductionOverview.Total</td>
							<td class="numberCell">{{total | bidiNumber:"":false:false}}</td>
						</tr>
					</tbody>
				</table>
				<div class="verticalLine"><div class="indicationArrow"></div></div>
			</div>
		</div>
		<div class="contentBox premiumBonus transparent">
			<h6 class="contentBoxHeader headerTrapezoidal">
				<div class="content" translate>
					ProductionOverview.PremiumBonus
				</div>
			</h6>
			<div class="contentBoxBody">
				<div class="title" data="bonus: {{productionBonusValue | bidiNumber:'percent':true:false}}" translate>ProductionOverview.ProductionWithoutBonus</div>
				{{interimBalance}} <span options="{{currentResourceType}}" translate>ProductionOverview.Resource_?</span>
				<div class="horizontalLine"></div>
				<div class="title" data="bonus: {{productionBonusValue | bidiNumber:'percent':true:false}}" translate>ProductionOverview.ProductionWithBonus</div>
				<div>{{theoreticalGoldBonus}} <span options="{{currentResourceType}}" translate>ProductionOverview.Resource_?</span></div>

				<button ng-if="productionBonusTime > 0"
						class="premium"
						premium-feature="{{premiumFeatureName}}">
					<span translate>ProductionOverview.RenewBonus</span>
				</button>
				<button ng-if="productionBonusTime == 0"
						class="premium"
						premium-feature="{{premiumFeatureName}}">
					<span translate>ProductionOverview.GetBonus</span>
				</button>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/productionOverview/tabs/Balance.html"><div class="productionContainer balance">
	<div class="contentBox">
		<h6 class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="unit_crop_medium_illu"></i>
			<span translate>ProductionOverview.Balance.Title</span>
		</h6>
		<div class="contentBoxBody">
			<div class="contentBox">
				<div class="contentBoxBody">
					<span translate>ProductionOverview.Balance.ProductionBuildingsAndOasis</span>
					<span class="contentBoxValue">{{productionBuildings | bidiNumber:"":false:false}}</span>
				</div>
				<div class="contentBoxBody">
					<span translate>ProductionOverview.Balance.ProductionHero</span>
					<span class="contentBoxValue">{{heroProduction | bidiNumber:"":false:false}}</span>
				</div>
				<div class="contentBoxBody">
					<span translate>ProductionOverview.Balance.ProductionOasisTroops</span>
					<span class="contentBoxValue">{{oasisTroopProduction | bidiNumber:"":false:false}}</span>
				</div>
				<div class="contentBoxBody">
					<span translate>ProductionOverview.TreasureProduction</span>
					<span class="contentBoxValue">{{treasureProduction | bidiNumber:"":false:false}}</span>
				</div>
				<div class="contentBoxBody">
					<span translate data="percentage:{{productionBonusValue | bidiNumber:'percent':true:false}}">ProductionOverview.GoldBonusProduction</span>
					<span class="contentBoxValue">{{goldBonus | bidiNumber:"":false:false}}</span>
				</div>
				<div class="arrowContainer arrowDirectionTo">
					<span class="arrowInside" translate>ProductionOverview.Balance.InterimBalance</span>
					<span class="arrowOutside">{{interimBalanceForTroops | bidiNumber:"":false:false}}</span>
				</div>
				<div class="contentBoxBody">
					<span translate>ProductionOverview.Balance.Consumption.Buildings</span>
					<span class="contentBoxValue">{{population | bidiNumber:"":false:false}}</span>
				</div>
				<div class="subContentBox">
					<div class="expandableHead" clickable="toggle('showOwnSummary')">
						<div class="icon">
							<i ng-class="showOwnSummary ? 'symbol_minus_tiny_flat_white' : 'symbol_plus_tiny_flat_white'"></i>
						</div>
						<div ng-class="{'item':showOwnSummary}">
							<span translate>ProductionOverview.Balance.Consumption.OwnTroops</span>
							<span class="contentBoxValue" ng-show="!showOwnSummary">{{troops.own.sum | bidiNumber:"":false:false}}</span>
						</div>
					</div>
					<div ng-show="showOwnSummary">
						<div class="expandableItem">
							<span translate>ProductionOverview.Balance.Troop.InVillage</span>
							<span class="contentBoxValue">{{troops.own.village | bidiNumber:"":false:false}}</span>
						</div>
						<div class="expandableItem">
							<span translate>ProductionOverview.Balance.Troop.InOasis</span>
							<span class="contentBoxValue">{{troops.own.oasis | bidiNumber:"":false:false}}</span>
						</div>
						<div class="expandableItem">
							<span translate>ProductionOverview.Balance.Troop.Moving</span>
							<span class="contentBoxValue">{{troops.own.elsewhere | bidiNumber:"":false:false}}</span>
						</div>
						<div class="expandableItem">
							<span translate>ProductionOverview.Balance.Troop.Trapped</span>
							<span class="contentBoxValue">{{troops.own.trapped | bidiNumber:"":false:false}}</span>
						</div>
						<div class="expandableItem">
							<span translate>ProductionOverview.Balance.Troop.Healing</span>
							<span class="contentBoxValue">{{troops.own.healing | bidiNumber:"":false:false}}</span>
						</div>
					</div>
				</div>
				<div class="subContentBox">
					<div class="expandableHead" clickable="toggle('showOtherSummary')">
						<div class="icon">
							<i ng-class="showOtherSummary ? 'symbol_minus_tiny_flat_white' : 'symbol_plus_tiny_flat_white'"></i>
						</div>
						<div ng-class="{'item':showOtherSummary}">
							<span translate>ProductionOverview.Balance.Consumption.ForeignTroops</span>
							<span class="contentBoxValue" ng-show="!showOtherSummary">{{troops.other.village | bidiNumber:"":false:false}}</span>
						</div>
					</div>
					<div ng-show="showOtherSummary">
						<div class="expandableItem">
							<span translate>ProductionOverview.Balance.Troop.InVillage</span>
							<span class="contentBoxValue">{{troops.other.village | bidiNumber:"":false:false}}</span>
						</div>
					</div>
				</div>
				<div class="arrowContainer arrowDirectionTo total" ng-class="{negative : interimBalanceForTroops+troops.own.sum+troops.other.sum < 0}">
					<span class="arrowInside" translate>ProductionOverview.Balance.Total</span>
					<span class="arrowOutside">{{balanceTotal | bidiNumber:"":false:false}}</span>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/productionOverview/tabs/Clay.html"><div ng-include src="'tpl/productionOverview/partials/Resource.html'"></div>
</script>
<script type="text/ng-template" id="tpl/productionOverview/tabs/Crop.html"><div ng-include src="'tpl/productionOverview/partials/Resource.html'"></div>
</script>
<script type="text/ng-template" id="tpl/productionOverview/tabs/Iron.html"><div ng-include src="'tpl/productionOverview/partials/Resource.html'"></div>
</script>
<script type="text/ng-template" id="tpl/productionOverview/tabs/Wood.html"><div ng-include src="'tpl/productionOverview/partials/Resource.html'"></div>
</script>
<script type="text/ng-template" id="tpl/profile/playerProfile.html"><div ng-controller="playerProfileCtrl" class="playerProfile">
	<player-profile playerId="{{playerId}}"></player-profile>
	<div class="infoWrapper">
		<div class="playerVillages">
			<table class="fixedTableHeader" scrollable>
				<thead>
					<tr>
						<th class="name">
							<i tooltip tooltip-translate="Villages" class="village_village_small_flat_black"></i> ({{playerData.villages.length}})
						</th>
						<th class="coordinates"><i class="symbol_target_small_flat_black"></i></th>
						<th class="population">
							<i tooltip tooltip-translate="Population" class="unit_population_small_flat_black"></i></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="village in playerData.villages | orderBy:'population':true">
						<td class="name">
							<span village-link villageid="{{village.villageId}}" villagename="{{village.name}}"></span>
							<i ng-if="village.isMainVillage" class="village_main_small_flat_black" tooltip tooltip-translate="Village.main"></i>
						</td>
						<td class="coordinates">
							<div coordinates aligned="true" x="{{village.coordinates.x}}" y="{{village.coordinates.y}}"></div>
						</td>
						<td class="population">{{village.population}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="contentBox gradient playerDescription">
			<div class="contentBoxHeader headerColored">
				<span translate>Description</span>
				<i class="headerButton"
				   ng-show="canEditDescription"
				   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
				   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
				   clickable="openOverlay('playerProfileEditDescription');"
				   tooltip tooltip-translate="Player.EditDescription"></i>
			</div>
			<div class="contentBoxBody" scrollable>
				<div user-text-parse="playerProfile.description" parse="decorations;medals;achievements" class="desc"></div>
			</div>
		</div>
	</div>
	<div class="horizontalLine" ng-hide="myPlayerId == playerId"></div>
	<div class="contentWrapper" ng-hide="myPlayerId == playerId">
		<div class="openChat">
			<button tooltip tooltip-translate="Chat.Open"
					clickable="openChat(getPrivateRoomName(playerData.playerId))">
				<span translate>Chat.Open</span>
			</button>
		</div>
		<div class="iconButton beAFriend"
			 ng-class="{disabled: !userAddable(playerData.playerId)}"
			 tooltip tooltip-translate-switch="{
				'Chat.AddFriend': {{!!userAddable(playerData.playerId)}},
				'Chat.CantAddFriend': {{!userAddable(playerData.playerId)}}
			 }"
			 clickable="addFriend(playerData.playerId)">
			<i class="community_playerAdd_small_flat_black"></i>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/prestige.html"><div class="prestigeTab" ng-controller="prestigeTabCtrl">
    <div class="leftCol">
        <div class="currentWeekEstimation">
            <div class="contentBox">
                <div class="contentBoxHeader">
                    <span translate>Prestige.WeekEstimation</span>
                    <div class="estimatedPrestigeThisWeek">
                        <div class="withArrowTip"></div>
                        <span class="weekPrestigeAmount">{{weekPrestigeAmount}}</span>
                        <i class="feature_prestige_small_flat_black"></i>
                        <div class="arrow"></div>
                    </div>
                </div>
                <div class="contentBoxBody">
                    <div translate class="timeLeft" data="days:{{remainingDays}}">Prestige.TimeLeft</div>
                    <div class="horizontalLine"></div>
                    <div translate class="prestigeEstimationExplanation">Prestige.WeekEstimation.Explanation</div>
                </div>

            </div>
        </div>
        <div class="clear"></div>
        <div class="currentPrestigeLevel">
            <div class="contentBox">
                <div class="contentBoxHeader">
                    <span translate>Prestige.Currentlevel</span>
                    <div class="headerWithArrowEndings goldenEnding">
                        <div class="content">
                            <prestige-stars stars="stars" size="small"></prestige-stars>
                        </div>
                    </div>
                </div>
                <div class="spacing"></div>
                <div class="contentBoxBody">
                    <div class="prestigeCategoryRow">
                        <div class="prestigeCategoryName" translate>
                            Prestige.Category.ThisServer
                        </div>
                        <div class="prestigeCategoryIcon">
                            <i class="feature_prestige_small_flat_black"></i>
                        </div>
                        <div class="prestigeCategoryAmount">{{gameworldPrestige}}</div>
                    </div>
                    <div class="horizontalLine"></div>
                    <div class="prestigeCategoryRow">
                        <div class="prestigeCategoryName" translate>
                            Prestige.Category.Overall
                        </div>
                        <div class="prestigeCategoryIcon">
                            <i class="feature_prestige_small_flat_black"></i>
                        </div>
                        <div class="prestigeCategoryAmount">{{globalPrestige}}</div>
                    </div>
                    <div class="horizontalLine"></div>
                    <div class="prestigeCategoryRow">
                        <div class="prestigeCategoryName" ng-if="nextLevelGlobalPrestige == 0" translate>Prestige.Category.MaxLevel</div>
                        <div class="prestigeCategoryName" ng-if="nextLevelGlobalPrestige != 0" translate>Prestige.Category.NextLevel</div>
                        <div class="prestigeCategoryIcon">
                            <i class="feature_prestige_small_flat_black inactive"></i>
                        </div>
                        <div class="prestigeCategoryAmount">{{nextLevelGlobalPrestige ? nextLevelGlobalPrestige : '-'}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rightCol currentConditions" scrollable>
        <div class="contentBox">
            <div class="contentBoxHeader centeredTitle headerColored">
                <span translate>Prestige.Report.FromFulfilledConditions</span>
            </div>
            <div class="conditionTable">
                <table class="columnOnly">
                    <tr class="conditionTableRow" ng-class="{'conditionTableRowLast':$last, 'fulfilled': condition.fulfilled}" ng-repeat="condition in conditions | orderBy:'conditionType'">
                        <td class="conditionTableColumn conditionTableColumnCheckbox">
                            <span class="checkBox" ng-class="{'positive': condition.fulfilled, 'negative': !condition.fulfilled}" ng-if="condition.type=='ranking'" tooltip tooltip-data="rankings" tooltip tooltip-url="tpl/profile/partials/rankingPrestigeTooltip.html" tooltip-placement="above">
                                <i class="action_check_small_flat_white"></i>
                            </span>
                            <span ng-if="!condition.tooltipTranslationKey && (condition.type!='ranking' || rankingConditions.length == 0)" ng-class="{'positive': condition.fulfilled, 'negative': !condition.fulfilled}" class="checkBox">
                                <i class="action_check_small_flat_white"></i>
                            </span>
                            <span ng-if="condition.tooltipTranslationKey && (condition.type!='ranking' || rankingConditions.length == 0)" tooltip tooltip-translate="{{condition.tooltipTranslationKey}}" ng-class="{'positive': condition.fulfilled, 'negative': !condition.fulfilled}" class="checkBox">
                                <i class="action_check_small_flat_white"></i>
                            </span>
                        </td>
                        <td class="conditionTableColumn conditionTableColumnName">
                            <span class="conditionName">{{condition.title}}</span>
                        </td>
                        <td class="conditionTableColumn conditionTableColumnAchieved" ng-bind-html="0 | bidiRatio:condition.croppedValue:condition.threshold:true"></td>
                    </tr>
                </table>
            </div>
            <div class="spacing"></div>
            <div class="clear"></div>
            <div class="contentBoxHeader centeredTitle headerColored">
                <span translate>Prestige.Report.FromTop10Ranking</span>
                <span class="prestigeRankingHeaderPrestige">
                    <i class="feature_prestige_small_flat_black" tooltip tooltip-translate="Prestige.Top10.Header.Tooltip"></i>
                </span>
            </div>
            <div class="conditionTable">
                <table class="columnOnly">
                    <tr class="conditionTableRow" ng-class="{'conditionTableRowLast':$last}" ng-repeat="ranking in top10rankings">
                        <td class="conditionTableColumn conditionTableColumnIcon">
                            <i class="{{ranking.iconClass}}"></i>
                        </td>
                        <td class="conditionTableColumn conditionTableColumnName">
                            <span class="conditionName">{{ranking.title}}</span>
                        </td>
                        <td class="conditionTableColumn conditionTableColumnAchieved rank">
                            <span>{{ranking.rank}}</span>
                        </td>
                        <td class="conditionTableColumn conditionTableColumnPrestige">
                            <i class="feature_prestige_small_flat_black" ng-if="ranking.rank <= 10"></i>
                            <span ng-if="ranking.rank <= 10">{{ranking.prestige}}</span>
                            <span ng-if="ranking.rank > 10">-</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div></script>
<script type="text/ng-template" id="tpl/profile/profile.html"><div class="profileWindow" ng-controller="profileWindowCtrl">
    <div ng-include="tabBody_tab"></div>
</div></script>
<script type="text/ng-template" id="tpl/profile/profileHeader.html"><div class="contentHeader">
	<h2 ng-bind="w.playerData.name"></h2>
</div>
</script>
<script type="text/ng-template" id="tpl/profile/settings.html"><div class="settings" ng-controller="settingsCtrl">
	<div tabulation tab-config-name="settingsTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>

	<div class="buttonFooter marginToScrollbar">
		<button clickable="saveSettings()" ng-class="{disabled: !somethingChanged()}">
			<span translate>Button.Save</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/partials/rankingPrestigeTooltip.html"><div class="rankingPrestigeRowTooltip">
    <h3 translate>Prestige.Report.RankingTooltipHeader</h3>
    <div class="horizontalLine"></div>
    <table class="transparent">
        <tr ng-repeat="ranking in rankings">
            <th><span translate options="{{ranking.conditionType}}">Prestige.Ranking.Type_?</span></th>
			<td ng-if="ranking.conditionType != PrestigeCondition.HOLD_TOP_RANKING">
				{{ranking.achievedValue|rank}} ({{ranking.finalValue | bidiNumber:'':true:true}})
			</td>
			<td ng-if="ranking.conditionType == PrestigeCondition.HOLD_TOP_RANKING">{{ranking.achievedValue}}</td>
        </tr>
    </table>
    <span translate>Prestige.RankingTooltip.Explanation</span>
</div></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/achievementTooltip.html"><span ng-if="!achievementData.extraData" class="achievementName" translate options="{{achievementData.type}}">Achievements.Title_?</span>
<div ng-if="achievementData.extraData" class="achievementName" translate
	  data="serverName:{{::achievementData.extraData.serverName}},
					 	allianceTag:{{::achievementData.extraData.allianceTag}},
					 	allianceRank:{{::achievementData.extraData.allianceRank}}"
	  options="{{::achievementData.type}},{{::achievementData.langKeySuffix}}"
	>Achievements.Title_??</div>
<span ng-if="(achievementData.special == 'false' || achievementData.special == false || achievementData.special == 0)" translate data="level:{{::achievementData.level}}">Achievements.Level</span></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/medalTooltip.html"><span translate options="{{type}}">Medal.Type_?</span></br>
<span translate>Medal.Week</span> {{week}}</br>
<span translate>Medal.Rank</span> {{rank}}</script>
<script type="text/ng-template" id="tpl/profile/playerProfile/playerProfileEditDescription.html"><div class="playerProfileEditDescription">
	<div class="contentBox transparent description">
		<div class="contentBoxHeader headerColored" translate>PlayerProfile.Description</div>
		<div class="contentBoxBody">
			<textarea id="desc" maxlength="15000" ng-model="playerProfile.data.description" auto-focus></textarea>
		</div>
	</div>
	<div class="contentBox transparent medals">
		<div class="contentBoxHeader headerColored" translate>
			Player.EditDescription.MedalsAndAchievements
		</div>
		<div class="contentBoxBody" scrollable>
			<div class="medalWrapper">
				<div class="medal" ng-repeat="medal in medals.data">
					<medal-image type="{{medal.data.type}}" rank="{{medal.data.rank+1}}" week="{{medal.data.week}}" clickable="addMedal({{medal.data.medalId}},{{medal.data.type}},{{medal.data.rank+1}},{{medal.data.week}})"></medal-image>
				</div>
			</div>
			<div class="horizontalLine" ng-if="achievements.data.length > 0 && medals.data.length > 0"></div>
			<div class="achievementWrapper" ng-if="achievements.data.length > 0">
				<achievement-image ng-repeat="achievement in achievements.data" player-id="{{achievement.data.playerId}}" type="{{achievement.data.type}}" clickable="addAchievement({{achievement.data.type}});">
				</achievement-image>
			</div>
		</div>
	</div>
	<div class="horizontalLine"></div>
	<div class="buttonWrapper">
		<button clickable="cancel()" class="cancelDescriptionButton cancel">
			<span translate>Button.Cancel</span>
		</button>
		<button clickable="send()" class="saveDescriptionButton">
			<span translate>Button.Save</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/playerProfileEditProfile.html">playerProfileEditProfile</script>
<script type="text/ng-template" id="tpl/profile/playerProfile/playerProfileFullImage.html"><div class="playerProfileFullImage contentBox gradient double">
	<div class="contentBoxHeader headerWithArrowEndings glorious">
		<div class="content">{{playerData.name}}</div>
	</div>
	<div class="contentBoxBody">
		<div class="heroImage {{avatar.gender}}">
			<hero-image-file style="z-index: 1" file="{{avatar.gender+'/body/330x422/'+'base0'}}"></hero-image-file>

			<div class="faceOffset">
				<avatar-image player-id="{{playerId}}" hide-hair="helmet" hide-ears="helmet" no-shoulders="true"></avatar-image>
			</div>
			<hero-image-file
				ng-repeat="obj in heroBodyImages"
				ng-style="{zIndex: obj.z}"
				ng-class="{slotBag:obj.stackable, helmet:obj.helmet}"
				file="{{avatar.gender+'/body/330x422/'+obj.img}}"></hero-image-file>
			<hero-image-file
				ng-if="!heroBodyImages[HeroItem.SLOT_RIGHT_HAND]"
				ng-style="{zIndex: obj.z}"
				class="heroRightHand"
				file="{{avatar.gender+'/body/330x422/'+'arm_right'}}"></hero-image-file>
			<hero-image-file
				ng-if="!heroBodyImages[HeroItem.SLOT_LEFT_HAND]"
				ng-style="{zIndex: obj.z}"
				class="heroLeftHand"
				file="{{avatar.gender+'/body/330x422/'+'arm_left'}}"></hero-image-file>
		</div>
		<div ng-show="activeHeroItem !== null" class="heroItemInformation contentBox transparent">
			<div class="contentBoxHeader" translate options="{{activeHeroItem.data.itemType}}">Hero.Item_?</div>
			<div class="contentBoxBody">
				<div ng-repeat="(index, bonus) in activeHeroItem.data.bonuses">
					<span translate ng-show="index!=11 && index!=12" options="{{index}}" data="x:{{bonus}}">Hero.ItemBonus_?</span>
					<span translate ng-show="index==11" options="{{index}}" data="x:{{activeHeroItem.bonusUnitStrength}}, unitName: {{activeHeroItem.bonusUnitName}}">Hero.ItemBonus_?</span>
				</div>
			</div>
		</div>
		<div class="heroItems">
			<hero-item-container
				ng-repeat="slot in [1,4,5,6,2,3]"
				hide-equipped="true"
				hide-upgrade="true"
				tooltip-condition="false"
				item="heroSlots[slot]"
				highlight-obj="highlightObj"
				>
			</hero-item-container>

		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/playerProfilePlayerInvitesPlayer.html"><div class="playerProfilePlayerInvitesPlayer" ng-controller="playerProfilePlayerInvitesPlayerCtrl">
    <div tabulation class="subtab" tab-config-name="playerInvitesTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/pip/ActiveInvites.html"><div class="full">
	<mellon-frame src="{{activeInvitesIframe}}" additional-class="activeInvitesIframe"></mellon-frame>
</div></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/pip/Invite.html"><div class="full">
	<mellon-frame src="{{invitePlayerIframe}}" additional-class="invitePlayerIframe"></mellon-frame>
</div></script>
<script type="text/ng-template" id="tpl/profile/playerProfile/pip/PendingInvites.html"><div class="full">
	<mellon-frame src="{{pendingInvitesIframe}}" additional-class="pendingInvitesIframe"></mellon-frame>
</div></script>
<script type="text/ng-template" id="tpl/profile/settings/partials/getExternalLogin.html"><div class="externalLoginOverlay">
	<div ng-if="!externalLoginKey">
		<div translate>Settings.ExternalTools.Description</div>
		<div translate>ExternalLogin.CreateHeadline</div>
		<div class="siteKeyInputContainer">
			<label>
				<span translate>ExternalLogin.SiteKey</span>:
				<input ng-model="input.publicSiteKey" id="publicSiteKey" name="publicSiteKey" type="text">
			</label>
		</div>
		<div class="buttonFooter">
			<button clickable="requestExternalLogin();" ng-class="{disabled: input.publicSiteKey == null || input.publicSiteKey == ''}">
				<span translate>Settings.ExternalTools.Button</span>
			</button>
		</div>
		<div class ="error">{{apiError}}</div>
	</div>
	<div ng-if="externalLoginKey">
		<span translate>ExternalLogin.YourKey</span>:
		<span class="loginKey">{{externalLoginKey}}</span>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/settings/partials/startDeletion.html"><div>
	<div translate>DeleteAccount.Description</div>
	<div ng-if="useMellon">
		<div class="buttonFooter">
			<button clickable="deleteAccount();">
				<span translate>DeleteAccount.Button</span>
			</button>

			<button class="cancel" clickable="closeOverlay();">
				<span translate>Button.Cancel</span>
			</button>
		</div>
	</div>
	<div ng-if="!useMellon">
		<div translate>DeleteAccount.Confirm</div>
		<label>
			<span translate>Password</span>:
			<input ng-model="input.deletePassword" id="deletePassword" name="deletePassword" type="password">
		</label>
		<button ng-class="{disabled: input.deletePassword == null || input.deletePassword == ''}"
				clickable="deleteAccount();">
			<span translate>DeleteAccount.Button</span>
		</button>
		<div class ="error">{{deletionError}}</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/profile/settings/tabs/Avatar.html"><div class="contentBox">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.ShareOnlineStatus</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow">
				<td class="label" translate>Settings.ShareOnlineStatus.Description</td>
				<td class="setting">
					<div dropdown data="onlineStatusDropdown">
						<span translate options="{{option}}">Settings.ShareOnline_?</span>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="contentBox">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.LanguageLocation</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow">
				<td class="label" translate>Settings.ChooseTimeZone</td>
				<td class="setting">
					<div dropdown data="timeZoneDropdown">{{option.text}}</div>
				</td>
			</tr>

			<tr class="settingsRow">
				<td class="label" translate>Settings.ChooseTimeFormat</td>
				<td class="setting">
					<div dropdown data="timeFormatDropdown"><span translate options="{{option}}">Settings.TimeFormat.?</span></div>
				</td>
			</tr>

			<tr class="settingsRow" ng-if="languageDropdown.options.length > 1">
				<td class="label" translate>Settings.ChangeLanguage</td>
				<td class="setting">
					<div dropdown data="languageDropdown">{{option.languageName}}</div>
				</td>
			</tr>
		</table>

	</div>
</div>

<div class="contentBox">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.SittersAndDuals</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow">
				<td class="label" translate>Settings.SittersAndDuals.Description</td>
				<td class="setting">
					<button clickable="openLobby();">
						<span translate>Settings.SittersAndDuals.Button</span>
					</button>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="contentBox">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.ExternalTools</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow">
				<td class="label" translate>Settings.ExternalTools.ShortDescription</td>
				<td class="setting">
					<button clickable="openOverlay('getExternalLogin')">
						<span translate>Settings.ExternalTools.Button</span>
					</button>
				</td>
			</tr>
		</table>
	</div>
</div>


<div class="contentBox" ng-if="canDeleteAccount || player.data.deletionTime > 0 || goldDeletionTimeout">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>DeleteAccount</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow" ng-show="player.data.deletionTime <= 0 && !goldDeletionTimeout">
				<td class="label" translate>DeleteAccount.ShortDescription</td>
				<td class="setting">
					<button ng-class="{disabled: player.data.deletionTime > 0}" ng-if="!player.data.kingstatus"
							clickable="openOverlay('startDeletion');">
						<span translate>DeleteAccount.Button</span>
					</button>
					<button class="disabled" ng-if="player.data.kingstatus"
							tooltip tooltip-translate="DeleteAccount.King">
						<span translate>DeleteAccount.Button</span>
					</button>
				</td>
			</tr>
			<tr class="settingsRow" ng-show="player.data.deletionTime > 0">
				<td class="label" translate data="deletionTime: {{player.data.deletionTime}}">DeleteAccount.InProgress</td>
				<td class="setting">
					<button class="cancel" ng-class="{'disabled': !canAbortDeletion}"
							clickable="abortDeletion()"
							tooltip tooltip-translate="PlayerDeletion.Abort.NotPossible" tooltip-hide="canAbortDeletion"
					>
						<span translate>DeleteAccount.Abort</span>
					</button>
				</td>
			</tr>
			<tr class="settingsRow" ng-show="goldDeletionTimeout">
				<td colspan="2">
					<span translate data="deletionTimeout: {{player.data.lastPaymentTime + goldUnblockTime}}">DeleteAccount.goldDeletionTimeout</span>
				</td>
			</tr>
		</table>
		<div class ="error" ng-show="error">{{error}}</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/profile/settings/tabs/FX.html">
<div class="contentBox audioSettings">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.Audio</div>
	</div>
	<div class="contentBoxBody unselectable">
		<table>
			<tr class="settingsRow">
				<td class="label" translate>Settings.Audio.Disabled</td>
				<td class="setting">
					<switch switch-name1="No" switch-name2="Yes" switch-model="mute.all" switch-callback="onSoundChange"></switch>
				</td>
			</tr>

			<tr class="settingsRow">
				<td class="label" translate>Settings.Audio.Music</td>
				<td class="setting">
					<slider slider-min="0" slider-max="100" slider-data="music" slider-changed="onSoundChange" slider-show-max-button="false"
							slider-lock="mute.all" ng-class="{disabled: mute.all}"></slider>
				</td>
			</tr>

			<tr class="settingsRow">
				<td class="label" translate>Settings.Audio.Sound</td>
				<td class="setting">
					<slider slider-min="0" slider-max="100" slider-data="sound" slider-changed="onSoundChange" slider-show-max-button="false"
							slider-lock="mute.all" ng-class="{disabled: mute.all}"></slider>
				</td>
			</tr>

			<tr class="settingsRow">
				<td class="label" translate>Settings.Audio.UiSound</td>
				<td class="setting">
					<slider slider-min="0" slider-max="100" slider-data="uiSound" slider-changed="onSoundChange" slider-show-max-button="false"
							slider-lock="mute.all" ng-class="{disabled: mute.all}"></slider>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="contentBox audioSettings">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.Graphic</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow" tooltip tooltip-translate="Settings.SettingTooltip_disableAnimations">
				<td class="label" translate>Settings.Setting_disableAnimations</td>
				<td class="setting">
					<switch switch-name1="No" switch-name2="Yes" switch-model="checkboxSettings['disableAnimations'].value"></switch>
				</td>
			</tr>
		</table>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/profile/settings/tabs/Gameplay.html"><div class="contentBox">
	<div class="contentBoxHeader headerTrapezoidal">
		<div class="content" translate>Settings.ChangeSettings</div>
	</div>
	<div class="contentBoxBody">
		<table>
			<tr class="settingsRow" ng-repeat="(key, item) in checkboxSettings" ng-if="key != 'disableAnimations'" tooltip tooltip-translate="Settings.SettingTooltip_{{key}}" tooltip-show="{{checkboxSettings[key].hasTooltip}}">
				<td class="label" translate options="{{key}}">Settings.Setting_?</td>
				<td class="setting">
					<switch switch-name1="No" switch-name2="Yes" switch-model="checkboxSettings[key].value"></switch>
				</td>
			</tr>
			<tr class="settingsRow">
				<td class="label" translate>Settings.PremiumConfirmation.Description</td>
				<td class="setting">
					<div dropdown data="premiumConfirmationDropdown">
						<span translate options="{{option}}">Settings.PremiumConfirmation_?</span>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/questBook/questBook.html"><div class="questsBook" ng-controller="questBookCtrl">
	<div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/questBook/tabs/DailyQuests.html"><div ng-controller="dailyQuestsCtrl" class="dailyQuests contentBox gradient" ng-class="{adventures: isAdventure}">
	<div class="contentBoxBody">
		<div ng-if="possibleQuests.length == 0" translate>Quest.QuestBook.NoQuest</div>
		<div class="selectionContainer unselectable">
			<div ng-repeat="dailyQuest in possibleQuests track by $index" class="possibleQuest">
				<div ng-if="dailyQuest!=='empty'"
					class="clickableContainer"
					 clickable="selectDailyQuest({{dailyQuest.data.id}})"
					 ng-class="{active: dailyQuest.data.id == questId}">
					<i class="dailyQuestsIcon"></i>
					<span class="questName ng-scope">
						<span translate options="{{dailyQuest.headerKey}}">QuestHeader_?</span>
					</span>

					<i ng-if="dailyQuest.data.status == QuestModel.STATUS_DONE" class="symbol_star_small_illu doneMarker"></i>

					<div ng-if="dailyQuest.data.status == QuestModel.STATUS_ACTIVATABLE" class="newMarker">
						<i class="character_exclamation_mark_tiny"></i>
					</div>

					<div class="selectionArrow" ng-if="dailyQuest.data.id == questId"></div>
				</div>
				<div ng-if="dailyQuest=='empty'"
					 class="clickableContainer disabled">
					<i class="dailyQuestsIcon"></i>
					<span class="questName ng-scope">
						<span translate>Quest.DailyQuest.SlotEmpty</span>
					</span>

				</div>
				<div class="contentBox" ng-if="dailyQuest!=='empty'">
					<div progressbar perc="{{dailyQuest.data.finishedSteps * 100 / dailyQuest.data.finalStep}}" ng-class="{completed: dailyQuest.data.status == QuestModel.STATUS_DONE}"
								 tooltip tooltip-show="{{dailyQuest.data.finalStep > 1 && dailyQuest.data.finalStep > dailyQuest.data.finishedSteps}}"
								 tooltip-translate="QuestProgress_{{dailyQuest.headerKey}}" tooltip-data="x:{{dailyQuest.data.finalStep - dailyQuest.data.finishedSteps}}"></div>
				</div>
			</div>

			<div class="contentBox statusNote">
				<div ng-if="!slotsFull" class="statusNoteTitle" data="nextTimestamp:{{nextDailyQuestTimestamp}}" translate>Quest.DailyQuest.StatusTitle.NextQuest</div>
				<div ng-if="slotsFull" class="statusNoteTitle" translate>Quest.DailyQuest.StatusTitle.SlotsFull</div>
				<div class="horizontalLine"></div>
				<div ng-if="!slotsFull" class="statusNoteBody" translate>Quest.DailyQuest.StatusBody.NextQuest</div>
				<div ng-if="slotsFull" class="statusNoteBody" translate>Quest.DailyQuest.StatusBody.SlotsFull</div>
			</div>
		</div>

		<div class="detailContainer fewQuests" ng-if="questId > 0" ng-include="'tpl/questDetails/questDetails.html'"></div>
		<div class="detailContainer fewQuests" ng-if="questId == 0">
			<div class="questDetailsContent">
				<i class="questGiverPointing"></i>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/questBook/tabs/OpenQuests.html"><div ng-controller="openQuestsCtrl" class="quests contentBox gradient" ng-class="{adventures: isAdventure}">
	<div class="contentBoxBody">
		<div ng-if="possibleQuests.length == 0" translate>Quest.QuestBook.NoQuest</div>
		<div class="selectionContainer unselectable">
			<div pagination current-page="currentPage"
						items-per-page="itemsPerPage"
						number-of-items="numberOfItems"
						display-page-func="displayCurrentPage"
						startup-position="{{startPosition}}"
						route-named-param="cp"
						class="questPagination">
				<div ng-repeat="quest in questsOnPage" class="possibleQuest">
					<div class="clickableContainer"
						 clickable="selectQuest({{quest.data.id}})"
						 ng-class="{active: quest.data.id == questId}">
						<i ng-if="!isAdventure" class="questGiverIcon questGiver{{quest.data.questGiver}}"></i>
						<span class="questName ng-scope">
							<span translate options="{{quest.headerKey}}">QuestHeader_?</span>
						</span>

						<div ng-if="isAdventure" class="horizontalLine double"></div>
						<i ng-if="quest.data.status == QuestModel.STATUS_DONE" class="symbol_star_small_illu doneMarker"></i>

						<div ng-if="quest.data.status == QuestModel.STATUS_ACTIVATABLE && !isAdventure" class="newMarker">
							<i class="character_exclamation_mark_tiny"></i>
						</div>
						<i ng-if="isAdventure" class="adventureDuration"
						   ng-class="{adventure_short_large_illu: quest.data.data == 1, adventure_long_large_illu: quest.data.data == 2}"></i>

						<div class="selectionArrow" ng-if="quest.data.id == questId"></div>
					</div>
					<div ng-if="!isAdventure" class="contentBox">
						<div progressbar perc="{{quest.data.finishedSteps * 100 / quest.data.finalStep}}" ng-class="{completed: quest.data.status == QuestModel.STATUS_DONE}"
									 tooltip tooltip-show="quest.data.finalStep > 1 && quest.data.finalStep > {{quest.data.finishedSteps}}"
									 tooltip-translate="QuestProgress_{{quest.headerKey}}" tooltip-data="x:{{quest.data.finalStep - quest.data.finishedSteps}}"></div>
					</div>
				</div>

				<div ng-if="isAdventure" class="currentAdventurePoints contentBox">
					<h6 class="contentBoxHeader headerColored">
						<span translate>Adventures.AdventurePoints</span>
					</h6>
					<div class="contentBoxBody">
						<div class="current">
							<span><span translate>Adventures.YouHave</span>: </span><i class="unit_adventurePoint_small_illu"></i> &times;
							<span class="value">{{hero.data.adventurePoints}}</span>
						</div>
						<div class="next">
							<span><span translate>Adventures.NextPointIn</span>: </span><span class="countdown" countdown="{{hero.data.adventurePointTime}}"></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="detailContainer" ng-if="questId > 0" ng-class="{fewQuests: possibleQuests.length < 4}" ng-include="'tpl/questDetails/questDetails.html'"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/questDetails/questDetails.html"><div ng-controller="questDetailsCtrl" class="questDetailsContent">
	<div class="borderWrapper">
		<div class="header">
			<img src="layout/images/x.gif" class="quest{{quest.data.id}} {{tribeName}} {{kingStatus}}"/>
			<h6 class="headerWithArrowEndings important ng-scope" ng-if="headerText != ''">
				<span class="content">{{headerText}}</span>
			</h6>
		</div>
		<div translate options="{{questSummaryKey}}" data="finalStep:{{quest.data.finalStep}}">?</div>
		<div class="horizontalLine" ng-show="rewardCnt > 0 || isAdventure"></div>
		<div ng-if="isAdventure" class="buttonWrapper">
			<i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="Duration"></i> {{quest.data.progress|HHMMSS}}
			<div ng-if="hero.data.status != 0">
				<i class="heroStatus status{{hero.data.status}}"></i>
				<span translate options="{{hero.data.status}}"
						   data="duration: {{hero.data.untilTime}},
								villageId: {{hero.data.villageId}},
								destVillageId: {{hero.data.destVillageId}},
								destVillage: {{hero.data.destVillageName}},
								playerId: {{hero.data.destPlayerId}},
								playerName: {{hero.data.destPlayerName}}">
					Hero.Status_?
				</span>
			</div>
			<div class="horizontalLine"></div>

			<div ng-if="isAdventure" class="adventureCosts">
				<span translate>Adventures.Costs</span>
				: <i class="unit_adventurePoint_small_illu"></i> &times; <span class="value">{{quest.data.data}}</span>
			</div>
			<button ng-class="{disabled: hero.data.status != 0 || hero.data.adventurePoints < quest.data.data}"
					clickable="acceptQuest()"
					tooltip tooltip-translate-switch="{
						'Adventures.AdventurePoints.NotEnough': {{hero.data.adventurePoints < quest.data.data}},
						'Error.HeroNotIdle': {{hero.data.status != 0}}
					}">
				<span translate>Adventures.StartAdventure</span>
			</button>
		</div>
		<div class="rewardWrapper" ng-show="rewardCnt > 0">
			<h2 translate>Quest.Reward</h2>

			<div class="rewards" ng-repeat="(type, value) in rewards">
				<reward type="type" value="value" size="small" check-storage="questCompleted" flying-res-trigger="flyingResTrigger"></reward>
			</div>
		</div>
		<div class="buttonWrapper" ng-if="questCompleted !== true && !childWindow && !isAdventure" clickable="acceptQuest()">
			<div class="horizontalLine"></div>
			<button>
				<span translate>Quest.AcceptQuest</span>
			</button>
		</div>
		<div class="buttonWrapper" ng-if="questCompleted === true">
			<div class="horizontalLine"></div>
			<button clickable="closeWindow('questDetails')" class="cancel smaller" ng-if="!childWindow">
				<span translate>Quest.CollectRewardLater</span>
			</button>
			<button clickable="collectReward()" class="larger" ng-class="{disabled: lockQuestView}" ng-if="!error">
				<span translate>Quest.CollectReward</span>
			</button>
			<button clickable="collectReward()" class="larger disabled" ng-if="error" tooltip-placement="above" tooltip tooltip-content="{{error}}">
				<span translate>Quest.CollectReward</span>
			</button>
		</div>
		<div class="exchangeDailyQuest" ng-if="showExchangeQuestButton" tooltip
			 tooltip-data="nextTimestamp: {{nextDailyQuestTimestamp}}"
			 tooltip-translate-switch="{
					'Quest.DailyQuest.ExchangeButton.Enabled': {{dailyQuestsExchanged == 0}},
					'Quest.DailyQuest.ExchangeButton.Disabled': {{dailyQuestsExchanged > 0}}
				}">
			<a class="iconButton clickable" clickable="exchangeDailyQuest()" ng-class="{disabled: dailyQuestsExchanged >= maxDailyQuestsExchanged}" ng-if="showExchangeQuestButton">
				<i></i>
			</a>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/questDetails/questRewards.html"><div class="rewards" ng-repeat="(type, value) in rewards">
	<reward type="type" value="value" size="small" check-storage="questCompleted"></reward>
</div>
</script>
<script type="text/ng-template" id="tpl/questDialog/questDialog.html"><div ng-controller="questDialogCtrl" clickable="nextLine()" class="questDialogBG unselectable">
	<div class="dialogActor position0" ng-class="{show: dialogStarted}">
		<img src="layout/images/x.gif"
			 class="actor_{{getCharacter(actors[0])}}_illustration"/>
		<img src="layout/images/x.gif" class="emotion {{getCharacter(actors[0])}} actor_{{getCharacter(actors[0])}}_emotion_{{currentEmotion}}_illustration"/>
		<div class="tooltip textBubble position0 {{actors[0] == 0 ? 'above' : 'after'}} type{{currentType}} actor_{{getCharacter(actors[0])}}" ng-class="{show: currentActor == 0}">
			<div class="tooltipContent ownText">
				<div ng-if="currentType != 'MC' || currentActor != 0">
					<div class="spokenText">{{currentText0}}</div>
					<div class="tutorial_gravestone_illustration" ng-if="currentType=='input'">
						<div class="name">{{input.text}}</div>
					</div>
					<form ng-submit="submitForm()" ng-if="currentType=='input'">
						<div class="horizontalLine"></div>
						<input type="text" id="dialogInputField" autocomplete="off" ng-model="input.text" maxlength="15">
						<div class="buttonWrapper">
							<button clickable="submitForm()"><span translate>Button.Ok</span></button>
						</div>
					</form>
				</div>
				<div ng-if="currentType == 'MC' && currentActor == 0">
					<ul>
						<li ng-repeat="currentLine in MClines" clickable="nextLine({{currentLine.lineNr}})">
							<a>{{currentLine.text}}</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="dialogActor position1 questGiverPortrait questGiver{{actors[1]}}" ng-class="{show: currentActor == 1}">
		<img src="layout/images/x.gif"
			 class="actor_{{getCharacter(actors[1])}}_illustration"/>
		<div class="tooltip textBubble position1 {{actors[1] == 0 ? 'above' : 'before'}} actor_{{getCharacter(actors[1])}}" ng-class="{show: currentActor == 1}">
			<div class="tooltipContent ownText">
				<div ng-if="currentType != 'MC'  || currentActor != 1">
					{{currentText1}}
				</div>
				<div ng-if="currentType == 'MC' && currentActor == 1">
					<ul>
						<li ng-repeat="currentLine in MClines" clickable="nextLine({{currentLine.lineNr}})">
							<a>{{currentLine.text}}</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/questDirectionSelection/questDirectionSelection.html"><div ng-controller="questDirectionSelectionCtrl" class="questDirectionSelection">

	<div class="map tutorial_mapSelect_illustration">
		<div ng-repeat="(key, value) in directions"
			 class="direction {{value}}"
			 on-pointer-over="hover(key, true)"
			 on-pointer-out="hover(key, false)"
			 clickable="changeDirection(key);">
			<div class="selection">
				<div class="marker"
					 ng-show="highlightElement[key]['marker'] || highlightElement[key]['clicked']">
				</div>
			</div>
			<div class="label"
				 ng-show="(highlightElement[key]['label']  || highlightElement[key]['clicked']) && direction != 0 && showAll"
				 translate options="{{key}}">
				Quest.DirectionSelection.Direction_?.Label
			</div>
			<div class="sign"
				 ng-show="showAll"
				 ng-class="{highlight: highlightElement[key]['label']}"
				 translate
				 options="{{key}}">
				Quest.DirectionSelection.Direction_?.Sign
			</div>
		</div>
		<div class="direction random">
			<div clickable="changeDirection(0);"
				 on-pointer-over="hover(0, true)"
				 on-pointer-out="hover(0, false)"
				 class="selection">
				<div class="sign"
					 ng-class="{highlight: highlightElement[0]['label']}">
					<i class="symbol_questionMark_small_flat_white"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="mapPlacement">
		<h6 class="contentBoxHeader headerWithArrowEndings">
			<div class="content">
				<span translate>Quest.DirectionSelection.SelectDirection.Title</span>
			</div>
		</h6>
		<div class="directionChoice">
			<div class="option random">
				<label>
					<input type="radio" name="cardinalDirection" ng-model="showAll" data-ng-value="false" ng-change="updateCardianalChoice()">
					<span translate>Quest.DirectionSelection.SelectDirection.bestPosition</span>
				</label>
			</div>
			<div class="option ownChoice">
				<label>
					<input type="radio" name="cardinalDirection" ng-model="showAll" data-ng-value="true" ng-change="updateCardianalChoice()">
					<span translate>Quest.DirectionSelection.SelectDirection.chooseCardinal</span>
				</label>
			</div>

		</div>
		<div class="horizontalLine"></div>
		<!--Text for chosen Direction-->
		<div class="cardinalText" ng-show="choseDirection">
			<strong translate options="{{direction}}">Quest.DirectionSelection.SelectDirection.Title_?</strong>
			<p translate>Quest.DirectionSelection.SelectDirection.FurtherInformation</p>
		</div>
		<div class="cardinalText" ng-show="!choseDirection">
			<strong translate>Quest.DirectionSelection.SelectDirection.ChooseCardinal.Headline</strong>
			<p translate>Quest.DirectionSelection.SelectDirection.ChooseCardinal.FurtherInformation</p>
		</div>
	</div>

	<div class="buttonFooter">
		<button clickable="acceptDirection();" ng-class="{disabled: !choseDirection}">
			<span translate>Quest.DirectionSelection.FoundVillage</span>
		</button>
	</div>

	<div class="error" ng-show="choseDirectionError">
		<i class="symbol_warning_tiny_flat_red"></i><span translate>{{choseDirectionError}}</span>
	</div>

	<!--<div class="findFriend">-->
	<!--<h6 class="headerWithArrowEndings">-->
	<!--<div class="content">-->
	<!--<span translate>Quest.DirectionSelection.SearchForFriend</span>-->
	<!--</div>-->
	<!--</h6>-->
	<!--<label>-->
	<!--<span translate>Quest.DirectionSelection.SearchFriend</span>-->
	<!--<serverautocomplete change-input="clearPlayerId()" autocompletedata="{{serverAutocompleteName}}" autocompletecb="{{autocompleteCallback}}" model-input="input.targetName"></serverautocomplete>-->
	<!--</label>-->
	<!--</div>-->

</div>
</script>
<script type="text/ng-template" id="tpl/questPuzzle/questPuzzle.html"><div ng-controller="questPuzzleCtrl" class="puzzleContent">
	<div class="errorWrapper" ng-show="showError">
		<div class="tooltip errorMsg">
			<div class="tooltipContent">
				<span translate>Quest.PuzzleNotSolved</span>
				<div class="horizontalLine"></div>
				<button clickable="hideError()"><span translate>Button.Ok</span></button>
			</div>
		</div>
	</div>
	<div class="questPuzzleField" on-pointer-out="deselectAll()">
		<div class="entityBox draggable image tile{{tileNr}}"  ng-repeat="tileNr in [1,2,3,4,5,6,7,8,9]" ng-class="{active: selectedTile == tileNr}"
			ng-style="position[tileNr]"
			on-pointer-over="mouseOver({{tileNr}})"
			draggable="tileNr" dropable="switchTiles(object, {{tileNr}})">
			<img ng-src="data:image/jpg;base64,{{tileImage[tileNr]}}">
			<i class="dragMarker"></i>
			<div class="overlay" ng-class="overlayClass[tileNr]" clickable="selectTile({{tileNr}}, true)"></div>
		</div>
	</div>
	<button class="solve" clickable="sendSolution()"><span translate>Quest.SolvePuzzle</span></button>
</div>
</script>
<script type="text/ng-template" id="tpl/questVictory/questVictory.html"><div ng-controller="questVictoryCtrl" id="questVictoryWindow" clickable="close()" ng-class="{fadeIn: fadeIn, fadeOut: fadeOut}">
	<div class="victoryGlow victory_glow_illustration"></div>
	<div class="victoryIllustation victory_quest{{victoryScreenId}}_illustration"></div>
	<div class="descriptionWrapper victory_banderole_illustration">
		<div translate options="{{questId}}">QuestVictory_?</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/relocation/relocation.html"><div ng-controller="relocationCtrl" class="relocation">
	<div ng-repeat="option in relocation" class="movingOption">
		<player-profile playerId="{{option.playerId}}"></player-profile>
		<div class="newPosition">
			<div class="iconButton centerMapButton"
				 tooltip tooltip-translate="CellDetails.CenterMap"
				 clickable="openPage('map', 'centerId', '{{option.cellId}}_{{currentServerTime}}'); closeWindow(w.name);">
				<i class="symbol_target_small_flat_black"></i>
			</div>
			<button clickable="relocate({{option.playerId}}, {{option.cellId}})" ng-class="{'disabled': loading}"><span translate data="destCellId: {{option.cellId}}">Relocation.MoveTo</span></button>
		</div>
	</div>
	<div ng-show="relocation.length === 0" class="noOptions">
		<span translate>Relocation.NoOptions</span>
		<br/>
		<button disabled class="disabled"><span translate>Relocation.Move</span></button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/relocation/partials/header.html"><div class="contentHeader">
	<div>
		<h2>
			<span translate options="{{w.windowName}}">?</span>
		</h2>
		<div class="relocationHeader">
			<span translate ng-if="player.data.isKing">Relocation.King</span>
			<span translate ng-if="!player.data.isKing">Relocation.Governor</span>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/report/header.html"><div class="headerBox">
	<div class="reportHeaderBg reportType{{header.notificationType}} success{{header.successType}}"></div>
	<div class="playerBox actionFrom">
		<avatar-image player-id="{{header.sourcePlayerId}}"></avatar-image>
		<div class="playerLabel">
			<div class="playerAndAlliance">
				<span player-link playerId="{{header.sourcePlayerId}}"></span>
				<span ng-show="header.sourceAllianceTag && header.sourceAllianceTag != ''">({{header.sourceAllianceTag}})</span>
			</div>
			<div class="fromVillage">
				<span translate>Report.From</span>
				<span village-link villageName="{{header.sourceName}}" villageId="{{header.sourceId}}"></span>
				<i class="reportIcon reportIcon{{header.attackerReportType || header.notificationType}} colorIcon"></i>
			</div>
			<div class="prestigeStars"
				 ng-if="header.sourcePlayer && config.balancing.features.prestige">
				<prestige-stars stars="header.sourcePlayer.data.stars" size="tiny"></prestige-stars>
			</div>
			<div class="prestigeStarsTooltip"
				 tooltip
				 tooltip-translate-switch="{
				 	'Prestige.Stars.Tooltip.Own': {{!!player.data.nextLevelPrestige}},
				 	'Prestige.Stars.Tooltip.Own.Max': {{!player.data.nextLevelPrestige}},
				 }"
				 ng-if="header.sourcePlayer.data.playerId == player.data.playerId && config.balancing.features.prestige"
				 clickable="openWindow('profile', {'playerId': player.data.playerId, 'profileTab': 'prestige'})"
				 tooltip-data="prestige:{{player.data.prestige}},nextLevelPrestige:{{player.data.nextLevelPrestige}}"></div>
			<div ng-if="header.sourcePlayer.data.playerId != player.data.playerId && config.balancing.features.prestige"
				 class="prestigeStarsTooltip" tooltip tooltip-translate="Prestige.Stars.Tooltip.Other"></div>
		</div>
		<i class="shareBubble" ng-if="header.ownRole == 'attacker' && header.shareMessage" tooltip="{{header.shareMessage}}" tooltip-placement="above"></i>
	</div>
	<i class="resultIcon result_{{resultIcon}}_huge_illu" ng-if="resultIcon"></i>
	<div class="playerBox actionTo">
		<avatar-image player-id="{{header.destPlayerId}}"></avatar-image>
		<div ng-if="header.notificationType == Notifications.REPORT_FARMLIST_RAID" class="playerLabel">
			<span translate>Tab.FarmList</span>
			<div class="fromVillage">
				<a clickable="openWindow('building', {'location': 32, 'tab': 'FarmList', 'listId': {{header.destId}} });">{{header.destName}}</a>
			</div>
		</div>
		<div ng-if="header.notificationType != Notifications.REPORT_FARMLIST_RAID && header.notificationType != Notifications.REPORT_ADVENTURE" class="playerLabel">
			<div class="playerAndAlliance">
				<span player-link playerId="{{header.destPlayerId}}"></span>
				<span ng-show="header.destAllianceTag && header.destAllianceTag != ''">({{header.destAllianceTag}})</span>
			</div>
			<div class="fromVillage">
				<span translate>Report.From</span>
				<span village-link villageName="{{header.destName}}" villageId="{{header.destId}}"></span>
				<i ng-if="header.defenderReportType" class="reportIcon reportIcon{{header.defenderReportType}} colorIcon"
				   ng-class="{unknown: troopsDataDefender[0].unknown}"></i>
			</div>
			<div class="prestigeStars"
				 ng-if="header.destPlayer && config.balancing.features.prestige">
				<prestige-stars stars="header.destPlayer.data.stars" size="tiny"></prestige-stars>
			</div>
			<div class="prestigeStarsTooltip"
				 tooltip
				 tooltip-translate-switch="{
				 	'Prestige.Stars.Tooltip.Own': {{!!player.data.nextLevelPrestige}},
				 	'Prestige.Stars.Tooltip.Own.Max': {{!player.data.nextLevelPrestige}},
				 }"
				 ng-if="header.destPlayer.data.playerId == player.data.playerId && config.balancing.features.prestige"
				 clickable="openWindow('profile', {'playerId': player.data.playerId, 'profileTab': 'prestige'})"
				 tooltip-data="prestige:{{player.data.prestige}},nextLevelPrestige:{{player.data.nextLevelPrestige}}"></div>
			<div ng-if="header.destPlayer.data.playerId != player.data.playerId && config.balancing.features.prestige"
				 class="prestigeStarsTooltip" tooltip tooltip-translate="Prestige.Stars.Tooltip.Other"></div>
		</div>
		<div ng-if="header.notificationType == Notifications.REPORT_ADVENTURE" class="playerLabel">
			<div class="adventureLabel" translate>Report.Adventure</div>
		</div>

		<i class="shareBubble" ng-if="header.ownRole == 'defender' && header.shareMessage" tooltip="{{header.shareMessage}}" tooltip-placement="above"></i>
	</div>
</div>
<div class="successBar">
	<div ng-if="header[header.ownRole+'TroopLossSum']" class="lossBar" ng-style="{width: (header[header.ownRole+'TroopLossSum']*100/header[header.ownRole+'TroopSum'])+'%'}"></div>
	<div ng-if="body.hp || body.hp == 0" class="lossBar" ng-style="{width: (header.won ? body.hp : 100)+'%'}"></div>
</div>
<h6 class="functionHeader headerTrapezoidal">
	<div class="reportDate content">
		<span i18ndt="{{header.originalTime || header.time}}" format="shortDate"></span> |
		<span i18ndt="{{header.originalTime || header.time}}" format="mediumTime"></span>
	</div>

	<div class="controlPanel">
		<div class="iconButton shareReport"
			 ng-if="reportShareable()"
			 clickable="openOverlay('reportShare', {'reportToken': reportToken})"
			 tooltip tooltip-translate="Report.Tooltip.ShareReport" tooltip-placement="above">
			<i class="report_share_small_flat_black"></i>
		</div>

		<div class="iconButton favorite"
			 ng-class="{active: isFavorite}"
			 clickable="toggleFavorite()"
			 tooltip
			 tooltip-translate-switch="{
				'Report.Tooltip.RemoveAsFavorite': {{!!isFavorite}},
				'Report.Tooltip.MarkAsFavorite': {{!isFavorite && (usedReportToken == '')}}
			 }"
			 tooltip-placement="above">
			<i class="report_favorite_small_flat_black"></i>
		</div>
		<div class="iconButton attackAgain"
			 ng-if="(reportType == 'fightReport' || reportType == 'farmlistReport') && header.sourcePlayerId == player.data.playerId && header.sourceId > 0"
			 clickable="attackAgain()"
			 tooltip tooltip-translate="Report.AttackAgain" tooltip-placement="above">
			<i class="movement_attack_small_flat_black"></i>
		</div>

		<div class="iconButton simulator"
			 ng-if="reportType == 'fightReport' && !troopsDataDefender[0].unknown && !troopsDataAttacker[0].unknown && header.notificationType != Notifications.REPORT_FARMLIST_RAID"
			 clickable="toSimulator()"
			 tooltip tooltip-translate="Report.ToSimulator" tooltip-placement="above">
			<i class="report_simulate_small_flat_black"></i>
		</div>
	</div>
</h6>
</script>
<script type="text/ng-template" id="tpl/report/headerPrestige.html"><div class="headerBox">
	<div class="reportHeaderBg reportType{{header.notificationType}} success{{header.successType}}"></div>
	<div class="playerBox blockLeft">
		<div class="playerLabel">
			<span class="prestigeLabel" translate>Prestige.Level</span>
			<prestige-stars class="prestigeStarsContainer" stars="header.stars.stars" size="small"></prestige-stars>
		</div>
	</div>
	<div class="prestigeCup report_cup_big_illu">
		<div class="points">{{header.currentWeekPrestige | bidiNumber:'':true:true}}</div>
	</div>
	<i class="resultIcon result_{{resultIcon}}_huge_illu" ng-if="resultIcon"></i>
	<div class="playerBox blockRight">
		<div class="playerLabel">
			<div class="prestigeLabel" translate>Prestige.Total</div>
			<i class="feature_prestige_small_flat_black"></i>
			<span>{{header.globalPrestige}}</span>
		</div>
	</div>
</div>

<h6 class="functionHeader headerTrapezoidal">
	<div class="reportDate content">
		<span i18ndt="{{header.weekStartDate}}" format="shortDate"></span> -
		<span i18ndt="{{header.weekEndDate}}" format="shortDate"></span>
	</div>
	<div class="controlPanel">

		<div class="iconButton prestigeButton" clickable="openWindow('profile', {'playerId': header.sourcePlayerId, 'profileTab': 'prestige'})">
			<i class="feature_prestige_small_flat_black"></i>
		</div>

	</div>
</h6>
</script>
<script type="text/ng-template" id="tpl/report/report.html"><div class="inWindowPopup singleReport" ng-if="header.time">
	<div class="inWindowPopupHeader">
		<div class="navigation">
			<a class="back"
			   clickable="changeReport('prev')"
			   ng-class="{disabled: !prevNext.prev}"
			   play-on-click="{{UISound.OPEN_REPORT}}"
			   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
				<i ng-class="{
					symbol_arrowFrom_tiny_flat_black: !fromHover || (fromHover && !prevNext.prev),
					symbol_arrowFrom_tiny_flat_green: fromHover && prevNext.prev,
					disabled: !prevNext.prev
				}"></i>
			   <span translate>Report.Newer</span>
			</a> |
			<a class="forward"
			   clickable="changeReport('next')"
			   ng-class="{disabled: !prevNext.next}"
			   play-on-click="{{UISound.OPEN_REPORT}}"
			   on-pointer-over="toHover = true" on-pointer-out="toHover = false">
				<span translate>Report.Older</span>
				<i ng-class="{
					symbol_arrowTo_tiny_flat_black: !toHover || (toHover && !prevNext.next),
					symbol_arrowTo_tiny_flat_green: toHover && prevNext.next,
					disabled: !prevNext.next
				}"></i>
			</a>
		</div>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>

	<div class="reportCaption" ng-if="header.successType && header.notificationType != Notifications.REPORT_FARMLIST_RAID">
		<div class="banner result{{header.successType}}">
			<span class="content">
				<i class="reportIcon reportIcon{{header.ownRole ? header[header.ownRole+'ReportType'] : header.notificationType}} baseIcon"></i>
				<span options="{{headlineKey}}" ng-bind="reportHeadline"></span>
			</span>
		</div>
		<h6 ng-if="header.sharedBy" class="sharedHeader headerTrapezoidal">
			<div class="content">
				<span translate>Report.SharedBy</span>
				<span player-link playerId="{{header.sharedBy}}"></span>
			</div>
		</h6>
	</div>

	<div class="inWindowPopupContent">
		<div scrollable height-dependency="max">
			<div ng-include ng-if="reportType == 'prestigeReport'" class="reportHeader prestigeReportHeader" src="'tpl/report/headerPrestige.html'"></div>
			<div ng-include ng-if="reportType != 'prestigeReport'" class="reportHeader" src="'tpl/report/header.html'"></div>
			<div ng-include ng-if="reportType" class="reportBody {{reportType}}" src="'tpl/report/types/'+reportType+'.html'"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/report/shareReport.html"><div class="inWindowPopup">
	<div class="inWindowPopupHeader">
		<div class="navigation">
			<a class="back"
			   clickable="openOverlay('reportSingle')"
			   on-pointer-over="fromHover = true" on-pointer-out="fromHover = false">
				<i ng-class="{
					symbol_arrowFrom_tiny_flat_black: !fromHover,
					symbol_arrowFrom_tiny_flat_green: fromHover
				}"></i>
				<span translate>Button.Back</span>
			</a>
		</div>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div ng-include src="'tpl/report/partials/dialogShare.html'"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/report/partials/dialogShare.html"><div class="shareReport">
	<div class="optionContainer">
		<div class="contentBox">
			<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
				<i class="report_share_medium_flat_black"></i>
				<div class="content" translate>Report.ShareWith</div>
			</div>
		</div>
		<div class="clickableContainer" ng-disabled="user.data.kingdomId == 0"
			 ng-class="{active: shareWith=='kingdom', disabled: user.data.kingdomId == 0}" clickable="setShareWith('kingdom')">
			<i class="community_kingdom_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<div class="label" translate>Kingdom</div>
			<div class="selectionArrow" ng-if="shareWith=='kingdom'"></div>
		</div>
		<div class="clickableContainer" ng-disabled="user.data.allianceId == 0"
			 ng-class="{active: shareWith=='alliance', disabled: user.data.allianceId == 0}" clickable="setShareWith('alliance')">
			<i class="community_alliance_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<div class="label" translate>Alliance</div>
			<div class="selectionArrow" ng-if="shareWith=='alliance'"></div>
		</div>
		<div class="clickableContainer" ng-disabled="societies.data.length == 0"
			 ng-class="{active: shareWith=='secretSociety', disabled: societies.data.length == 0}" clickable="setShareWith('secretSociety')">
			<i class="community_secretSociety_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<div dropdown ng-if="societies.data.length > 0" data="dropdownData"></div>
			<div class="label" translate>SecretSociety</div>
			<div class="selectionArrow" ng-if="shareWith=='secretSociety'"></div>
		</div>
		<div class="clickableContainer" ng-class="{active: shareWith=='player'}" clickable="setShareWith('player')">
			<i class="community_player_medium_flat_black"></i>

			<div class="verticalLine double"></div>
			<!--<input type="text"/>-->
			<serverautocomplete change-input="clearPlayerId()" autocompletedata="player" autocompletecb="selectSharePlayer" ng-model="shareWithPlayerName"></serverautocomplete>

			<div class="label" translate>Player</div>
			<div class="selectionArrow" ng-if="shareWith=='player'"></div>
		</div>
	</div>

	<div class="commentContainer contentBox">
		<div class="contentBoxHeader headerWithIcon arrowDirectionTo">
			<i class="community_{{shareWith}}_medium_flat_black"></i>
			<div class="content" translate>Report.ShareAttachComment</div>
		</div>
		<div class="contentBoxBody">
			<textarea maxlength="{{shareMessageMaxLength}}" ng-model="$parent.$parent.shareMessage" class="shareMessage" auto-focus></textarea>
		</div>
	</div>
	<div class="directLink contentBox colored" ng-if="shareCode">
		<div class="contentBoxBody">
			<div translate>Report.DirectLinkDescription</div>
			<div class="reportCode">[report:{{shareCode}}]</div>
			<i class="reportIcon reportIcon{{reportType}} colorIcon draggableReport" draggable="{link: '[report:' + shareCode + ']'}"
			   tooltip tooltip-translate="Report.ShareIcon.Tooltip" tooltip-placement="above"></i>
		</div>
	</div>
	<button clickable="share()" ng-class="{disabled:((shareWith=='player' && (!shareWithPlayerId || shareWithPlayerId == '')) || shareWith=='') }">
		<span translate>Button.Share</span>
	</button>
	<div ng-if="error">
		<i class="symbol_warning_tiny_flat_red"></i> <span class="error">{{error}}</span>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/report/partials/farmlistDiedTroops.html"><h6 translate>Report.Farmlist.YourLosses</h6>
<div ng-if="target.sumDied > 0">
	<span ng-repeat="(nr, amount) in target.diedTroops" ng-show="amount > 0" class="lostTroops">
		<span unit-icon data="{{header.sourceTribeId}},{{nr}}"></span>
		{{amount}}
	</span>
</div>
<div ng-if="target.sumDied == 0">
	<span translate>None</span>
</div>
<div ng-if="target.sumCaptured > 0">
	<h6 translate>Report.Farmlist.Captured</h6>
	<span ng-repeat="(nr, amount) in target.capturedTroops" ng-show="amount > 0" class="lostTroops">
		<span unit-icon data="{{header.sourceTribeId}},{{nr}}"></span>
		{{amount}}
	</span>
</div>
<div ng-if="target.EnemyTroopLossSum > 0">
	<h6 translate>Report.Farmlist.EnemyLosses</h6>
	<div ng-repeat="(tribe, troops) in target.diedEnemyTroops">
		<span ng-repeat="(nr, amount) in troops" ng-show="amount > 0" class="lostTroops">
			<span unit-icon data="{{tribe}},{{nr}}"></span>
			{{amount}}
		</span>
	</div>
</div>
<div ng-if="target.EnemyTroopLossSum == 0">
	<h6 translate>Report.Farmlist.EnemyLosses</h6>
	<span translate ng-if="target.diedEnemyTroops !== null && target.diedEnemyTroops[1]">None</span>
	<span translate ng-if="target.diedEnemyTroops === null || !target.diedEnemyTroops[1]">Unknown</span>
</div>
</script>
<script type="text/ng-template" id="tpl/report/partials/farmlistResources.html"><div class="farmlistResourcesTooltip">
	<div class="lootCapacity">
		<i class="unit_capacity_small_flat_black"></i><span ng-bind-html="target.lootedResSum | bidiRatio : target.lootedResSum : target.carryCapacity"></span>
	</div>
	<display-resources resources="target.lootedRes"></display-resources>
</div>
</script>
<script type="text/ng-template" id="tpl/report/partials/farmlistSentTroops.html"><h6 translate>Report.Farmlist.YourTroops</h6>
<span ng-repeat="(nr, amount) in target.sentTroops" ng-show="amount > 0">
	<span unit-icon data="{{header.sourceTribeId}},{{nr}}"></span>
	{{amount}}
</span>
<div ng-if="target.enemyTroopSum > 0">
	<h6 translate>Report.Farmlist.DefenderTroops</h6>
	<div ng-repeat="(tribe, troops) in target.enemyTroops">
		<span ng-repeat="(nr, amount) in troops" ng-show="amount > 0" class="lostTroops">
			<span unit-icon data="{{tribe}},{{nr}}"></span>
			{{amount}}
		</span>
	</div>
</div>
<div ng-if="target.enemyTroopSum == 0">
	<h6 translate>Report.Farmlist.DefenderTroops</h6>
	<span translate ng-if="target.enemyTroops !== null && target.enemyTroops[1]">None</span>
	<span translate ng-if="target.enemyTroops === null || !target.enemyTroops[1]">Unknown</span>
</div></script>
<script type="text/ng-template" id="tpl/report/partials/healTooltip.html"><h3 translate>Troops.Healed.Header</h3>
<div class="horizontalLine"></div>
<div troops-details troop-data="infoModules.healed"></div>
</script>
<script type="text/ng-template" id="tpl/report/partials/lootTooltip.html"><table class="transparent lootTooltipTable">
	<thead>
		<tr>
			<th translate>Building_10</th>
			<th translate>Kingdom.TributeStorage</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="n in []|range:1:4">
			<td><i class="unit_{{resNames[n]}}_small_illu"></i> {{body.bounty[n]}}</td>
			<td ng-if="n!=4"><i class="unit_{{resNames[n]}}_small_illu"></i> {{body.tributeBounty[n]}}</td>
		</tr>
	</tbody>
</table>
</script>
<script type="text/ng-template" id="tpl/report/partials/rankingPrestigeRowTooltip.html"><div class="rankingPrestigeRowTooltip">
    <h3 translate>Prestige.Report.RankingTooltipHeader</h3>
    <div class="horizontalLine"></div>
    <table class="transparent">
        <tr ng-repeat="ranking in body.rankingConditions">
            <th><span translate options="{{ranking.conditionType}}">Prestige.Ranking.Type_?</span></th>
			<td ng-if="ranking.conditionType != PrestigeCondition.HOLD_TOP_RANKING">
				{{ranking.achievedValue|rank}} ({{ranking.finalValue | bidiNumber:'':true:true}})
			</td>
			<td ng-if="ranking.conditionType == PrestigeCondition.HOLD_TOP_RANKING">{{ranking.achievedValue}}</td>
        </tr>
    </table>
</div></script>
<script type="text/ng-template" id="tpl/report/types/adventureReport.html"><div class="adventureReport">
	<div class="contentBox colored heroInfo">
		<div class="contentBoxHeader">
			<div class="content" translate>Troop_hero</div>
		</div>
		<div class="contentBoxBody">
			<div ng-if="body.xp" tooltip tooltip-translate="Hero.Experience">
				<i class="unit_experience_small_flat_black"></i> {{body.xp | bidiNumber:'':true:true}}
			</div>
			<div ng-if="body.hp" class="heroDamage" tooltip tooltip-translate="Hero.Health">
				<i class="unit_health_small_flat_black"></i> -{{body.hp}}
			</div>
			<div ng-if="body.won && body.loot.length == 0" class="infoText" translate>Adventures.NoLootFound</div>
			<div ng-if="!body.won" class="infoText errorText" translate>Troops.HeroHasDied</div>
		</div>
	</div>

	<div ng-if="body.loot.length > 0" class="contentBox colored adventureBounty">
		<div class="contentBoxHeader">
			<div class="content" translate>Troops.Bounty</div>
		</div>
		<div class="contentBoxBody">
			<div class="bountyModule" ng-if="body.loot.resources">
				<display-resources resources="body.loot.resources"></display-resources>
			</div>
			<div class="bountyModule" ng-if="body.loot.silver">
				<span tooltip tooltip-translate="Silver"><i class="unit_silver_small_illu"></i> {{body.loot.silver}}</span>
			</div>
			<div class="bountyModule troopsBounty" ng-if="body.loot.troops">
				<div ng-repeat="(unitId, amount) in body.loot.troops">
					{{amount}}&times;<span unit-icon data="unitId" tooltip tooltip-translate="Troop_{{unitId}}"></span>
				</div>
			</div>
			<div class="bountyModule itemBounty" ng-if="body.loot.items">
				<div class="itemContainer" ng-repeat="item in body.loot.items">
					<div class="itemImage" tooltip tooltip-translate="Hero.Item_{{item.itemType}}">
						<div ng-if="item.amount > 1">{{item.amount}}&times;</div>
						<img src="layout/images/x.gif" class="heroItem_{{config.balancing.heroItems[item.itemType].images[0]}}_large_illu {{avatar.gender}}">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/report/types/farmlistReport.html"><div class="troopsScrollContainer">
	<div class="infoContainer">
		<div class="resourcesModule">
			<span class="caption" translate>Report.Modules.TotalLoot</span>
			<span class="loot">
				<i class="carry"
				   ng-class="{
				   		unit_capacityEmpty_small_flat_black: lootedResSum == 0,
						unit_capacityHalf_small_flat_black: lootedResSum > 0 && lootedResSum < carryCapacity,
						unit_capacity_small_flat_black: lootedResSum == carryCapacity
				   }"
				   tooltip tooltip-translate="Report.CarryCapacity" tooltip-placement="above"></i>
				{{0 | bidiRatio:lootedResSum:carryCapacity}}
			</span>

			<div class="bountyContainer">
				<span class="resources">
					<span ng-repeat="n in []|range:1:4">
						<i class="unit_{{resNames[n]}}_small_illu"></i>
						{{lootedRes[n] || 0}}
					</span>
				</span>
			</div>
		</div>
	</div>
	<div class="troopsDetailContainer">
		<div class="troopsDetailHeader fromHeader">
			<i class="reportIcon reportIcon{{troopDetails['successType']}} colorIcon"></i>
			<span translate>Attacker</span>:
			<span player-link playerId="{{header.sourcePlayerId}}" ng-if="header.sourcePlayerId != 1"></span>
			<span ng-if="header.sourcePlayerId == 1">{{header.sourcePlayerName}}</span>
			<span translate>Report.From</span>
			<span village-link villageId="{{header.sourceId}}" villageName="{{header.sourceName}}"></span>
			<div ng-if="header.sourceId > 2" class="iconButton centerMapButton"
				 tooltip tooltip-translate="CellDetails.CenterMap"
				 clickable="openPage('map', 'centerId', '{{header.sourceId}}_{{currentServerTime}}'); closeWindow(w.name);">
				<i class="symbol_target_small_flat_black"></i>
			</div>
		</div>
		<div troops-details troop-data="troopDetails"></div>
	</div>

	<div class="troopsDetailContainer">
		<div class="troopsDetailHeader toHeader">
			<i class="reportIcon reportIcon7 colorIcon"></i>
			<span translate>Report.TargetVillagesHeader</span>:
		</div>
		<table class="farmlistReportTable">
			<thead>
				<tr>
					<th><i class="movement_attack_small_flat_black"></i></th>
					<th><i class="secretSociety_troopsProvided_small_flat_black"></i></th>
					<th><i class="secretSociety_troopsLost_small_flat_black"></i></th>
					<th translate>TableHeader.Village</th>
					<th translate>Report.ArrivalTime</th>
					<th><i class="unit_capacity_small_flat_black"></i></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="target in body.targets" ng-class="{highlighted: highlight == target.destVillageId}">
					<td>
						<div ng-if="target.arrivalTime < $root.currentServerTime">
							<i ng-if="target.sumDied ==0" class="reportIcon reportIcon1 colorIcon"></i>
							<i ng-if="target.sumDied > 0 && target.sumDied < target.sumSent" class="reportIcon reportIcon2 colorIcon"></i>
							<i ng-if="target.sumDied >= target.sumSent" class="reportIcon reportIcon3 colorIcon"></i>
						</div>
					</td>
					<td tooltip tooltip-url="tpl/report/partials/farmlistSentTroops.html">{{target.sumSent}}</td>
					<td>
						<span tooltip tooltip-url="tpl/report/partials/farmlistDiedTroops.html" ng-if="target.sumDied > 0" class="lostTroops">-{{target.sumDied}}</span>
						<span ng-if="target.sumDied <=0" tooltip tooltip-url="tpl/report/partials/farmlistDiedTroops.html">-</span>
					</td>
					<td>
						<span village-link villageId="{{target.destVillageId}}" villageName=""></span>
					</td>
					<td ng-if="target.arrivalTime < $root.currentServerTime && target.arrivalTime > 0">
						<span i18ndt="{{target.arrivalTime}}" format="medium"></span>
					</td>
					<td ng-if="target.arrivalTime >= $root.currentServerTime && target.arrivalTime > 0">
						<span countdown="{{target.arrivalTime}}"></span>
					</td>
					<td ng-if="target.arrivalTime < 0" translate>
						Report.PendingAttack
					</td>
					<td ng-if="target.arrivalTime == 0" translate>
						Report.CanceledAttack
					</td>
					<td>
						<i class="carry"
						   ng-class="{
				   		unit_capacityEmpty_small_flat_black: target.lootedResSum == 0,
						unit_capacityHalf_small_flat_black: target.lootedResSum > 0 && target.lootedResSum < target.carryCapacity,
						unit_capacity_small_flat_black: target.lootedResSum > 0 && target.lootedResSum == target.carryCapacity
				   }"
						   tooltip tooltip-url="tpl/report/partials/farmlistResources.html"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</script>
<script type="text/ng-template" id="tpl/report/types/fightReport.html"><div class="troopsScrollContainer">
	<div class="infoContainer" ng-if="someInfoModules">
		<div ng-if="infoModules.loot || infoModules.spy" class="resourcesModule">
			<span ng-if="infoModules.loot" class="caption" translate>Report.Modules.Loot</span>
			<span ng-if="infoModules.spy && !infoModules.spy.noSurvivors" class="caption" translate>Report.Modules.Spy</span>
			<span ng-if="infoModules.loot" class="loot">
				<i class="carry"
				   ng-class="{
				   		unit_capacityEmpty_small_flat_black: infoModules.loot.allBountySum == 0,
						unit_capacityHalf_small_flat_black: infoModules.loot.allBountySum > 0 && infoModules.loot.allBountySum < infoModules.loot.capacity,
						unit_capacity_small_flat_black: infoModules.loot.allBountySum == infoModules.loot.capacity
				   }"
				   tooltip tooltip-translate="Report.CarryCapacityTooltip" tooltip-placement="above"
				   tooltip-data="percent:{{infoModules.loot.allBountySum/infoModules.loot.capacity*100|number:0}},used:{{infoModules.loot.allBountySum}},max:{{infoModules.loot.capacity}}"
					></i>
				{{0 | bidiRatio:infoModules.loot.allBountySum:infoModules.loot.capacity}}
			</span>

			<div class="bountyContainer" ng-if="(infoModules.bounty && infoModules.loot.allBountySum > 0) || infoModules.spy.resources || infoModules.treasures || infoModules.stolenGoods || infoModules.spy.treasures || infoModules.stolenGoods">
				<span class="resources"
					  tooltip tooltip-url="tpl/report/partials/lootTooltip.html" tooltip-show="{{body.tributeBounty}}" tooltip-placement="above">
					<span ng-repeat="n in []|range:1:4">
						<i class="unit_{{resNames[n]}}_small_illu"></i>
						{{infoModules.bounty[n] || infoModules.spy.resources[n] || 0}}
					</span>
				</span>
				<span class="treasures" ng-if="infoModules.treasures || infoModules.spy.treasures"
					  tooltip tooltip-translate-switch="{	'Resource.Treasures': !!infoModules.spy.treasures,
					  										'Report.TreasureAndVictoryPoints': !infoModules.spy.treasures}"
					  tooltip-placement="above">
					<i class="unit_treasure_small_illu"></i>
					{{infoModules.treasures || infoModules.spy.treasures}}
					<span ng-if="infoModules.treasures">
						<i class="unit_victoryPoints_small_flat_black"></i>
						{{infoModules.victoryPoints || 0}}
					</span>
				</span>
				<span class="stolenGoods" ng-if="infoModules.stolenGoods || infoModules.stolenGoods"
					  tooltip tooltip-translate="Resource.StolenGoods"
					  tooltip-placement="above">
					<i class="unit_stolenGoods_small_illu"></i>
					{{infoModules.stolenGoods || infoModules.stolenGoods}}
				</span>
			</div>
		</div>
		<div class="buildingsModule" ng-if="infoModules.spy.defence || infoModules.damage">
			<span class="caption" translate>Report.Modules.Buildings</span>

			<div class="buildingsContainer">
				<div ng-if="infoModules.spy.defence" class="buildingInfo" ng-repeat="building in infoModules.spy.defence track by $index">
					<span class="buildingLarge buildingType{{building.buildingType}} tribeId{{infoModules.spy.targetTribeId}}"
						 tooltip tooltip-translate="Building_{{building.buildingType}}"/></span>

				<div data="lvl:{{building.buildingLevel}}" translate>Building.Level</div>
				</div>
				<div ng-if="infoModules.damage" class="buildingInfo" ng-repeat="building in infoModules.damage track by $index" ng-if="building.buildingOriginalLevel > building.buildingFinalLevel">
					<span class="buildingLarge buildingType{{building.buildingType}} tribeId{{infoModules.damage.targetTribeId}}"
						  tooltip tooltip-translate="Building_{{building.buildingType}}"/></span>

					<div>{{building.buildingOriginalLevel}}
						<span class="finalLevel">{{building.buildingFinalLevel}}</span></div>
				</div>
			</div>
		</div>
		<div class="healedModule borderedBox" ng-if="infoModules.healed">
			<i class="movement_heal_small_flat_black" tooltip tooltip-url="tpl/report/partials/healTooltip.html"></i>
			<span translate data="amount:{{infoModules.healed.amount}}">Troops.Healed</span>
		</div>
		<div class="infoModule" ng-if="infoModules.infoTexts.length > 0 || infoModules.errorTexts.length > 0 ||
											(infoModules.spy.hiddenByAllCrannies || infoModules.spy.hiddenByAllCrannies == 0) ||
											(infoModules.spy.hiddenByTreasury || infoModules.spy.hiddenByTreasury == 0)">
			<span class="caption" translate>Report.Modules.Info</span>
			<table class="infoTable transparent">
				<tbody>
					<tr ng-if="infoModules.spy.hiddenByAllCrannies || infoModules.spy.hiddenByAllCrannies == 0 ||
								infoModules.spy.hiddenByTreasury || infoModules.spy.hiddenByTreasury == 0">
						<td>
							<span ng-if="infoModules.spy.hiddenByAllCrannies || infoModules.spy.hiddenByAllCrannies == 0"
								  class="spyInfo"
								  tooltip
								  tooltip-translate="Report.Spy.Cranny"
								  tooltip-placement="above">
								<i class="building_g23_small_illu"></i> {{infoModules.spy.hiddenByAllCrannies}}
							</span>
							<span ng-if="infoModules.spy.hiddenByTreasury || infoModules.spy.hiddenByTreasury == 0"
								  class="spyInfo"
								  tooltip
								  tooltip-translate="Report.Spy.HiddenTreasury"
								  tooltip-placement="above">
								<i class="building_g45_small_illu"></i> {{infoModules.spy.hiddenByTreasury}}
							</span>
						</td>
					</tr>
					<tr ng-repeat="infoText in infoModules.infoTexts">
						<td>{{infoText}}</td>
					</tr>
					<tr ng-repeat="errorText in infoModules.errorTexts">
						<td class="errorText">{{errorText}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="troopsDetailContainer" ng-repeat="troopDetails in troopsDataAttacker">
		<div class="troopsDetailHeader fromHeader">
			<i class="reportIcon reportIcon{{troopDetails['successType']}} colorIcon"
			   tooltip tooltip-show="body.attackType" tooltip-translate="Report.AttackTypeTooltip" tooltip-data="type:movementType_{{body.attackType}}"></i>
			<span translate>Attacker</span>:
			<span player-link playerId="{{header.sourcePlayerId}}" ng-if="header.sourcePlayerId != 1"></span>
			<span ng-if="header.sourcePlayerId == 1">{{header.sourcePlayerName}}</span>
			<span translate>Report.From</span>
			<span village-link villageId="{{header.sourceId}}" villageName="{{header.sourceName}}"></span>
			<div ng-if="header.sourceId > 2" class="iconButton centerMapButton"
				 tooltip tooltip-translate="CellDetails.CenterMap"
				 clickable="openPage('map', 'centerId', '{{header.sourceId}}_{{currentServerTime}}'); closeWindow(w.name);">
				<i class="symbol_target_small_flat_black"></i>
			</div>
		</div>
		<div troops-details troop-data="troopDetails"></div>
	</div>
	<div class="troopsDetailContainer" ng-repeat="troopDetails in troopsDataDefender | orderBy:['type', 'tribeId']"
		 ng-if="troopDetails.type == 'defender' || (!showTribeDetails[troopDetails.tribeId] && showTribeDetails[troopDetails.tribeId] !== false) ||
				troopDetails.isGroup && !showTribeDetails[troopDetails.tribeId] || !troopDetails.isGroup && showTribeDetails[troopDetails.tribeId]">
		<div class="troopsDetailHeader toHeader">
			<i class="reportIcon reportIcon{{troopDetails['successType'] + DEFENDER_OFFSET}} colorIcon" ng-class="{unknown: troopDetails['unknown']}"></i>
			<span ng-if="troopDetails.type == 'defender'"><span translate>Defender</span>:</span>
			<span ng-if="troopDetails.type == 'supporter'"><span translate>Troops.Supporting</span>:</span>
			<span player-link ng-if="troopDetails.playerId" playerId="{{troopDetails.playerId}}"></span>
			<span class="tribeLabel" ng-if="!troopDetails.playerId" translate options="{{troopDetails.tribeId}}">Tribe_?</span>
			<span ng-if="troopDetails.type == 'defender'">
				<span translate>Report.From</span>
				<span village-link villageId="{{troopDetails.villageId}}" villageName="{{troopDetails.villageName}}"></span>
			</span>
			<div ng-if="troopDetails.type == 'defender' && troopDetails.villageId > 2"
				 class="iconButton centerMapButton"
				 tooltip tooltip-translate="CellDetails.CenterMap"
				 clickable="openPage('map', 'centerId', '{{troopDetails.villageId}}_{{currentServerTime}}'); closeWindow(w.name);">
				<i class="symbol_target_small_flat_black"></i>
			</div>
		</div>
		<div troops-details troop-data="troopDetails"></div>
		<div class="troopActions" ng-if="troopDetails.isGroup">
			<a class="centered" clickable="showTribeDetails[troopDetails.tribeId] = true" translate>Report.Troops.ShowDetails</a>
		</div>
	</div>

	<div class="troopsDetailContainer" ng-repeat="troopDetails in troopsDataSummary">
		<div class="troopsDetailHeader toHeader">
			<i class="reportIcon reportIcon{{troopDetails['successType'] + DEFENDER_OFFSET}} colorIcon"></i>
			<span translate>Troops.Supporting</span>:
			<span class="tribeLabel" translate options="{{troopDetails.tribeId}}">Tribe_?</span>
		</div>
		<div troops-details troop-data="troopDetails"></div>
	</div>
</div>
<div ng-show="header.peaceType">
	<span translate options="{{header.peaceType}}" data="offPlayerName:{{header.sourcePlayerName}}">WorlPeace.Content.Type_?</span>
</div>

</script>
<script type="text/ng-template" id="tpl/report/types/prestigeReport.html"><div class="prestigeReport">
	<div class="weekOverviewHeader contentBox gradient">
		<span translate class="prestigeGainedText1">Prestige.AchievedTasks</span>
		<i class="feature_prestige_small_flat_black"></i>
		<span class="gainedPrestigeAmount">{{header.currentWeekPrestige}}</span>
		<span translate class="prestigeGainedText2">Prestige.PrestigeGained</span>
	</div>

	<div class="horizontalSeparator"></div>

	<div class="blockHeader" ng-if="body.medals.length > 0" translate>Prestige.Report.FromTop10Ranking</div>
	<div class="rankingRow" ng-repeat="medal in body.medals">
		<div class="prestigeMedal medal_{{medal.typeString}}Rank{{medal.rank+1}}_large_illu" ng-if="medal.rank < 3"></div>
		<div class="prestigeMedal medal_{{medal.typeString}}Rank4_large_illu" ng-if="medal.rank >= 3"></div>
		<div class="prestigeMedalRank" ng-if="medal.rank >= 3">{{medal.rank+1}}</div>
		<span class="rankingName" translate options="{{medal.type}}">Prestige.Report.WeekTop10Rank_?</span>
		<i class="feature_prestige_small_flat_black"></i>
		<span class="prestigePointsGained" ng-bind="medal.prestige"></span>
	</div>
	<div class="blockHeader" ng-class="{'noTopBorder': body.medals.length > 0}">
		<span translate>Prestige.Report.FromFulfilledConditions</span>
		<span class="challengesCount" ng-bind-html="0 | bidiRatio:body.totalFulfilled:body.conditions.length:true"></span>
	</div>
	<div class="horizontalSeparator"></div>
	<div class="conditionTable">
		<table class="columnOnly">
			<tr class="conditionTableRow" ng-repeat="condition in body.conditions | orderBy:'conditionType'" ng-class="{'conditionTableRowLast':$last, 'fulfilled': condition.fulfilled}">
				<td class="conditionTableColumn conditionTableColumnCheckbox">
					<div class="checkBox" ng-class="{'positive': condition.fulfilled, 'negative': !condition.fulfilled}" ng-if="condition.type=='ranking' && body.rankingConditions.length > 0" tooltip-data="body.rankingConditions" tooltip tooltip-url="tpl/report/partials/rankingPrestigeRowTooltip.html" tooltip-placement="above">
						<i class="action_check_small_flat_white"></i>
					</div>
					<div ng-if="!condition.tooltipTranslationKey && (condition.type!='ranking' || body.rankingConditions.length == 0)" ng-class="{'positive': condition.fulfilled, 'negative': !condition.fulfilled}" class="checkBox">
						<i class="action_check_small_flat_white"></i>
					</div>
					<div ng-if="condition.tooltipTranslationKey && (condition.type!='ranking' || body.rankingConditions.length == 0)" tooltip tooltip-translate="{{condition.tooltipTranslationKey}}" ng-class="{'positive': condition.fulfilled, 'negative': !condition.fulfilled}" class="checkBox">
						<i class="action_check_small_flat_white"></i>
					</div>
				</td>
				<td class="conditionTableColumn conditionTableColumnName">
					<span class="conditionName" translate options="{{condition.type}}">Prestige.ConditionName_?</span>
				</td>
				<td class="conditionTableColumn conditionTableColumnAchieved">
					<span class="achievedRatio" ng-bind-html="0 | bidiRatio:condition.croppedValue:condition.threshold:true"></span>
				</td>
				<td class="conditionTableColumn conditionTableColumnPrestige">
					<span>{{condition.prestige}}</span>
					<i class="feature_prestige_small_flat_black" ng-class="{'inactive': !condition.fulfilled}"></i>
				</td>
			</tr>
		</table>
		<div class="clear"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/report/types/tradeReport.html"><div class="contentBox  gradient tradeReport">
	<div class="contentBoxHeader">
		<div class="content" translate>Resources</div>
	</div>
	<div class="contentBoxBody">
		<display-resources resources="body.resources"></display-resources>
		<div class="horizontalLine"></div>
		<div class="tradeDuration" tooltip tooltip-translate="Troops.RunTime">
			<i class="symbol_clock_small_flat_black duration"></i> {{body.duration|HHMMSS}}
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/report/types/troopsReport.html"><div class="troopsScrollContainer">
	<div class="troopsDetailContainer" ng-repeat="troopDetails in troopsData">
		<div troops-details troop-data="troopDetails"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/reportConversation/reportConversation.html"><div class="reportConversation" ng-controller="reportConversationCtrl">
	<div ng-if="reportPlayer">
		<span translate>ReportPlayer.Description</span>
		<br><br>
		<label><input name="reason" type="radio" ng-model="form.reason" ng-value="PlayerPunishment.STRIKE_REASON_SPAM" checked/><span translate>ReportPlayer.Reason.Spam</span></label>
		<label><input name="reason" type="radio" ng-model="form.reason" ng-value="PlayerPunishment.STRIKE_REASON_HARASSMENT_INSULT"/><span translate>ReportPlayer.Reason.Harassment</span></label>
		<label><input name="reason" type="radio" ng-model="form.reason" ng-value="PlayerPunishment.STRIKE_REASON_ADVERTISING"/><span translate>ReportPlayer.Reason.Advertising</span></label>
	</div>
	<div ng-if="!reportPlayer">
		<span translate>ReportConversation.Description</span>
		<div class="additionalMessage">
			<textarea rows="4" maxlength="180" ng-model="comment"></textarea>
		</div>
	</div>
	<span class="error" ng-if="error">{{error}}</span>
	<div class="buttonFooter">
		<button clickable="submitReport()">
			<span translate ng-if="reportPlayer">ReportPlayer.SubmitReport</span>
			<span translate ng-if="!reportPlayer">ReportConversation.SubmitReport</span>
		</button>
		<button class="cancel" clickable="closeWindow('reportConversation');"><span translate>Button.Cancel</span></button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/reportSingle/reportSingle.html"><div class="reportWithoutOverlay" id="reportSingle" ng-controller="reportSingleCtrl">
	<div class="inWindowPopupContent">
		<div ng-include class="reportHeader" src="'tpl/report/header.html'"></div>
		<div ng-include ng-if="reportType" class="reportBody {{reportType}}" src="'tpl/report/types/'+reportType+'.html'"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/reports/reportStream.html"><div ng-controller="reportStreamCtrl" class="reportsList">
	<div class="reportFilter filterBar">
		<div class="filterGroup" ng-repeat="type in reportFilters track by $index" clickable="w.toggleFilter('{{type}}')">
			<a	class="filter iconButton"
				ng-class="{active: filterActive[type] == true}"
				tooltip tooltip-translate="Notification_{{type}}">
				<i class="reportIcon reportIcon{{type}}"></i>
			</a>
			<div class="subFilter" ng-show="filterActive[type]">
				<a class="filter iconButton" ng-repeat="type2 in reportFilterGroups[type]"
					ng-class="{active: filterActive[type2] == true}" clickable="w.toggleFilter({{type2}})"
					tooltip tooltip-translate="Notification_{{type2}}">
					<i class="reportIcon reportIcon{{type2}}"></i>
				</a>
			</div>
		</div>
	</div>

	<div ng-include src="'tpl/reports/partials/reportsTable.html'"></div>
</div></script>
<script type="text/ng-template" id="tpl/reports/reports.html"><div ng-controller="reportsCtrl">
    <div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/reports/reportsAlliance.html"><div ng-if="!isMinion">
	<div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='alliance'"></div>
</div>
<div ng-if="isMinion">
	<div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='alliance_minions'"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/reports/reportsFavorites.html"><div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='favorite'"></div></script>
<script type="text/ng-template" id="tpl/reports/reportsKingdom.html"><div ng-if="!isMinion">
	<div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='king'"></div>
</div>
<div ng-if="isMinion">
	<div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='king_minions'"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/reports/reportsOwn.html"><div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='own'"></div></script>
<script type="text/ng-template" id="tpl/reports/reportsSearch.html"><div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='search'"></div></script>
<script type="text/ng-template" id="tpl/reports/reportsSecretSociety.html"><div class="societyFilter">
	<div dropdown data="societyDropdown"></div>
</div>
<div ng-include src="'tpl/reports/reportStream.html'" onload="showCollection='society'"></div></script>
<script type="text/ng-template" id="tpl/reports/partials/reportsHeader.html"><div ng-init="showSearch = false" class="reportSearch">
		<span class="tabulation maintab">
			<a class="tab"
			   ng-click="showSearch = !showSearch"
			   on-pointer-over="iconHover = true"
			   on-pointer-out="iconHover = false"
			   ng-class="{active: tabData.currentTab == 'Search', inactive: tabData.currentTab != 'Search'}">
				<div class="content">
					<i ng-show="tabData.currentTab != 'Search'" ng-class="{action_search_small_flat_black: !iconHover, action_search_small_flat_green: iconHover}"></i>
					<i ng-show="tabData.currentTab == 'Search'" class="action_search_small_flat_white"></i>
				</div>
			</a>
		</span>
		<div class="searchWrapper" ng-if="showSearch">
			<serverautocomplete autocompletedata="player,village,coords"
								autocompletecb="w.searchReports"
								ng-model="w.searchInputOverride"
								input-autofocus="true"></serverautocomplete>
		</div>
</div>
<div class="contentHeader">
	<h2 translate>Reports</h2>
</div>
</script>
<script type="text/ng-template" id="tpl/reports/partials/reportsTable.html"><div pagination items-per-page="itemsPerPage"
			number-of-items="numberOfItems"
			current-page="pagination.currentPage"
			display-page-func="displayCurrentPage"
			route-named-param="cp">
	<table class="allianceReports">
		<thead>
			<tr>
				<th><span translate>TableHeader.Subject</span><span ng-if="tabData.currentTab == 'Search'"> ({{searchValue}})</span></th>
				<th translate>TableHeader.Sent</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="report in reports track by $index">
				<td class="reportDescription">
					<i class="reportIcon reportIcon{{report.notificationType}}" tooltip tooltip-translate="Notification_{{report.notificationType}}" ng-if="!report.sharedBy && report.displayType!=11 && report.displayType!=12"></i>
					<i class="reportIcon reportIcon0" tooltip tooltip-translate="Notification_{{report.notificationType}}" ng-if="report.sharedBy && report.displayType!=11 && report.displayType!=12"></i>
					<i class="reportIcon reportIcon{{report.outcome}} pending" tooltip tooltip-translate="Notification_115_115" ng-if="report.displayType==11"></i>
					<i class="reportIcon reportIcon{{report.outcome}}" tooltip tooltip-translate="Notification_{{report.outcome}}" tooltip-data="totalAmount: {{report.targetsTotal+'x'}}" ng-if="report.displayType==12"></i>
					<span class="truncated">
						<a clickable="openOverlay('reportSingle', {'reportId': '{{report._id.$id}}', 'collection': '{{report.collection}}'})" play-on-click="{{UISound.OPEN_REPORT}}">
							<span class="reportType{{report.displayType}}" translate options="{{report.displayType}}"
								  data="srcVillId:{{report.sourceId}},srcVillName:{{report.sourceName}},dstVillId:{{report.destId}},dstVillName:{{report.destName}},srcVill:{{report.sourceName}},dstVill:{{report.destName}}">
								Report.Subject_?
							</span>
						</a>
						<span class="addon" ng-show="report.displayType==11 || report.displayType==12" ng-if="report.targetsTotal != report.targetsFinished" translate data="totalAmount:{{report.targetsTotal}},currentAmount:{{report.targetsFinished}}">
							Report.SubjectAddon_11
						</span>
					</span>
					<span class="addon" ng-show="report.displayType==4 && report.capacity > 0">
						<i class="carry"
						   tooltip="{{0 | bidiRatio:report.bounty:report.capacity}}"
						   tooltip tooltip-translate="Report.CarryCapacityTooltip" tooltip-placement="above"
						   tooltip-data="percent:{{report.bounty/report.capacity*100|number:0}},used:{{report.bounty}},max:{{report.capacity}}"
						   ng-class="{
								unit_capacityEmpty_small_flat_black: report.bounty == 0,
								unit_capacityHalf_small_flat_black: report.bounty > 0 && report.bounty < report.capacity,
								unit_capacity_small_flat_black: report.bounty == report.capacity
						   }"></i>
					</span>
				</td>
				<td><span i18ndt="{{report.originalTime || report.time}}" format="short"></span></td>
			</tr>
			<tr ng-show="reports.length == 0">
				<td colspan="3">
					<span translate>Report.NoReports</span>
				</td>
			</tr>
		</tbody>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/screenFlashNotification/screenFlashNotification.html"><div ng-controller="screenFlashNotificationCtrl" class="screenFlashNotificationWindow" clickable="fadeOutAndClose()" ng-class="{fadeIn: fadeIn, fadeOut: fadeOut}">
	<div class="backgroundFlare rotate">
		<div class="flareRay" ng-repeat="n in []|range:0:10"></div>
	</div>
	<div ng-include ng-if="::windowParams.notificationType" class="screenNotificationContent {{::windowParams.notificationType}}" src="::'tpl/screenFlashNotification/types/'+windowParams.notificationType+'.html'"></div>
</div>
</script>
<script type="text/ng-template" id="tpl/screenFlashNotification/types/achievement.html"><div class="achievement_notification_huge_illu"></div>
<div class="achievementInfoArea">
	<div class="middleArea">
		<div class="captionEnding endingFrom achievement_captionFrom_layout"></div>
		<div class="captionEnding endingTo achievement_captionTo_layout"></div>
		<div class="achievementInfo">
			<span translate>Achievements.AchievementComplete</span>
			<div class="achievementInfoReward">
						<span>
							<b translate options="{{::windowParams.key}},{{langKeySuffix}}" data="{{extraTranslationParams}}">Achievements.Title_??</b>
							<b>{{windowParams.reward|bidiNumber:'':true}}</b>
							<i class="feature_prestige_small_flat_white"></i>
						</span>
			</div>
		</div>
	</div>
</div>
<div class="achievementIconWrapper">
	<i class="achievements_frame{{::windowParams.special === true || windowParams.special === 'true' ? 'Mystery' : windowParams.level}}_huge_illu achievementFrame"></i>
	<i ng-if="windowParams.level > 0 || windowParams.special" class="achievements_type{{::windowParams.key}}_large_illu achievementIcon"></i>
</div></script>
<script type="text/ng-template" id="tpl/screenFlashNotification/types/heroLevelUp.html"><div class="notificationBackground hero_levelUpNotification_huge_illu"></div>
<i class="levelStar symbol_star_small_illu"></i>
<span class="heroLevel length{{(hero.data.level+'').length}}">{{hero.data.level}}</span>
<span class="levelUpText" translate>Hero.LevelUpNotification</span></script>
<script type="text/ng-template" id="tpl/selectTribe/infoTooltip.html"><div class="selectTribeTooltip tribe{{input.tribe}}">
	<div class="category" translate>SelectTribe.TribeDescription.Category.Merchants</div>
	<ul options="{{input.tribe}}" translate>SelectTribe.TribeDescription.Category.Merchants.Tribe_?</ul>
	<div class="category" translate>SelectTribe.TribeDescription.Category.Troops</div>
	<ul options="{{input.tribe}}" translate>SelectTribe.TribeDescription.Category.Troops.Tribe_?</ul>
	<div class="category" translate>SelectTribe.TribeDescription.Category.Specials</div>
	<ul options="{{input.tribe}}" translate>SelectTribe.TribeDescription.Category.Specials.Tribe_?</ul>
</div>
</script>
<script type="text/ng-template" id="tpl/selectTribe/selectTribe.html"><div class="selectTribe" ng-controller="selectTribeCtrl">
	<div class="selectTribeContainer">
		<div class="serverContainer">
			<span translate>SelectTribe.SelectedServer</span>
			<span class="serverName">{{gameWorld}}</span>
		</div>
		<div class="headline">
			<div class="content" translate>SelectTribe.ChooseTribe</div>
		</div>
		<div class="characterCarousel">
			<div class="previous" clickable="previous();" ng-if="!instructionOpen">
				<i class="icon prevTribe"></i>
			</div>
			<div class="next" clickable="next();" ng-if="!instructionOpen">
				<i class="icon nextTribe"></i>
			</div>
			<div class="char tribeSelect_{{chars[0].tribeString}}{{chars[0].selected}}_illustration position{{chars[0].position}}"></div>
			<div class="char tribeSelect_{{chars[2].tribeString}}{{chars[2].selected}}_illustration position{{chars[2].position}}"></div>
			<div class="char tribeSelect_{{chars[1].tribeString}}{{chars[1].selected}}_illustration position{{chars[1].position}}"></div>
		</div>
		<div class="shortInfoContainer">
			<div class="headline">
				<div class="content" translate options="{{input.tribe}}">Tribe_?</div>
				<i class="information-tooltip" tooltip tooltip-url="tpl/selectTribe/infoTooltip.html" tooltip-placement="above"></i>
			</div>
			<div class="shortInfo">
				<ul translate options="{{input.tribe}}">
					SelectTribe.TribeShortDescription_?
				</ul>
			</div>
		</div>
		<div class="buttonContainer">
			<button class="chooseTribe" clickable="selectTribe();">
				<span translate>SelectTribe.FoundEmpire</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/sendTroops/SendTroopsConfirm.html"><div class="minHeightContainer">
	<div class="contentBox colored confirm-troops">
		<h6 class="contentBoxHeader headerTrapezoidal">
			<div class="content">
				<span class="missionType" translate options="{{input.movementType}}">RallyPoint.Troops.Movement_?</span>
			</div>
		</h6>
		<div class="contentBoxBody">
			<div class="participants sendTroops_headerBackground_illustration">
				<div class="movementIllustrationContainer">
					<img src="layout/images/x.gif" ng-class="{sendTroops_headerAttack_illustration: input.movementType==Troops.MOVEMENT_TYPE_ATTACK ||
						input.movementType==Troops.MOVEMENT_TYPE_RAID || input.movementType==Troops.MOVEMENT_TYPE_SIEGE,
						sendTroops_headerSupport_illustration: input.movementType==Troops.MOVEMENT_TYPE_SUPPORT,
						sendTroops_headerSpy_illustration: input.movementType==Troops.MOVEMENT_TYPE_SPY,
						sendTroops_headerSettle_illustration: input.movementType==Troops.MOVEMENT_TYPE_SETTLE}"></i>
				</div>

				<div class="startVillage">
					<span village-link villageid="{{checkTargetResult.srcVillageId}}" villagename="{{checkTargetResult.srcVillageName}}"></span>
					<br/>
					<span translate data="playerId: {{checkTargetResult.srcPlayerId}}, playerName: {{checkTargetResult.srcPlayerName}}">RallyPoint.ByPlayer</span>
				</div>
				<div class="targetVillage">
					<div ng-if="input.movementType != movementTypeSettle">
						<span village-link villageid="{{villageSearch.target.villageId}}" villagename="{{villageSearch.target.villageName}}"></span>
						<br/>
						<span translate data="playerId: {{villageSearch.targetPlayer.data.playerId}}, playerName: {{villageSearch.targetPlayer.data.name}}">RallyPoint.ByPlayer</span>
					</div>
					<div ng-if="input.movementType == movementTypeSettle">
						<span translate>HabitableField</span>
						<span village-link villageid="{{villageSearch.target.villageId}}" villagename="({{settleCoordinates.x}}|{{settleCoordinates.y}})"></span>
					</div>
				</div>
			</div>

			<div class="headerTrapezoidal">
				<div class="content">
					<span class="arrivalDuration" translate data="time: {{duration}}">RallyPoint.Troops.ArrivalIn</span>
					<span class="seperator"> | </span>
					<span class="arrivalTime" translate data="atTime: {{duration}}">atTimeShort</span>
				</div>
			</div>

			<div class="troopsDetailContainer chosenUnits">
				<div class="troopsDetailHeader fromHeader">
					<i class="attack colorIcon"></i>
					<span translate>RallyPoint.SendTroops.ChooseTroops</span>
				</div>
				<div troops-details troop-data="sendTroopsDetails"></div>
			</div>

			<div ng-if="input.movementType == 6" class="additionalInfo">
				<div dropdown data="spyTarget">
					<span>{{option.name}}</span>
				</div>
			</div>

			<div ng-if="numCatapults > 0 && rallyPoint.data.lvl >= 3 && isOasis == 0" class="additionalInfo">
				<div ng-if="input.movementType == 3 || input.movementType == 47" class="catapultTargetContainer">
					<span unit-icon data="troopDetails.tribeId, 8" tooltip tooltip-translate="Troop_{{catapultNr}}"></span>
					<span translate>RallyPoint.SendTroops.CatapultTarget.First</span>
					<div dropdown ng-show="rallyPoint.data.lvl >= 3" data="catapultTargets1">
					<span ng-class="{groupLabel: option.type=='group',groupMember: option.type=='member'}">{{option.name}}</span>
					</div>
					<div ng-show="numCatapults >= 20 && rallyPoint.data.lvl >= 20" class="secondCatapultTarget">
						<span translate>RallyPoint.SendTroops.CatapultTarget.Second</span>
						<div dropdown data="catapultTargets2">
							<span ng-class="{groupLabel: option.type=='group',groupMember: option.type=='member'}">{{option.name}}</span>
						</div>
					</div>
				</div>
			</div>

            <div class="additionalInfo" ng-show="showRedeployHero()">
                <label>
                    <span translate>RallyPoint.RedeployHero</span>
                    <input type="checkbox" ng-model="input.redeployHero" id="redeployHero" ng-change="toggleHeroRedeployWarning()">
                </label>
            </div>

			<div ng-show="input.movementType != 5 || input.redeployHero == true" class="additionalInfo">
				<div class="troopBox contentBox error" ng-repeat="warning in warningMsg">
					<div class="contentBoxHeader">
						<span class="arrowHeadline" translate>Warning</span>
						<span translate data="param:{{warning.param}}" options="{{warning.text}}">?</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="buttonContainer">
	<button class="sendTroops"
			ng-class="sendTypeClass"
			clickable="sendTroopsConfirm()"
			play-on-click="{{UISound.BUTTON_SEND_TROOPS}}">
		<span translate>Button.SendTroops</span>
	</button>
	<button class="back"
			clickable="goBack();"
			ng-hide="page == 'map' && input.movementType == Troops.MOVEMENT_TYPE_SETTLE"
			>
		<span translate>Button.Back</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/sendTroops/SendTroopsHome.html"><div class="contentBox colored confirm-troops">
	<h6 class="contentBoxHeader headerTrapezoidal">
		<div class="content">
			<span class="missionType" translate options="{{input.movementType}}">RallyPoint.Troops.Movement_?</span>
		</div>
	</h6>
	<div class="contentBoxBody">
		<div class="participants sendTroops_headerBackground_illustration">
			<div class="movementIllustrationContainer">
				<img src="layout/images/x.gif" class="sendTroops_headerSupport_illustration"></i>
			</div>
			<div class="startVillage">
				<span village-link villageid="{{checkTargetResult.srcVillageId}}" villagename="{{checkTargetResult.srcVillageName}}"></span>
				<br/>
				<span translate data="playerId: {{checkTargetResult.srcPlayerId}}, playerName: {{checkTargetResult.srcPlayerName}}">RallyPoint.ByPlayer</span>
			</div>
			<div class="targetVillage">
				<span village-link villageid="{{villageSearch.target.villageId}}" villagename="{{villageSearch.target.villageName}}"></span>
				<br/>
				<span translate data="playerId: {{villageSearch.targetPlayer.data.playerId}}, playerName: {{villageSearch.targetPlayer.data.name}}">RallyPoint.ByPlayer</span>
			</div>
		</div>

		<div class="headerTrapezoidal">
			<div class="content">
				<span class="arrivalDuration" translate data="time: {{duration}}">RallyPoint.Troops.ArrivalIn</span>
				<span class="seperator"> | </span>
				<span class="arrivalTime" translate data="atTime: {{duration}}">atTimeShort</span>
			</div>
		</div>

		<div class="troopsDetailContainer chosenUnits">
			<div class="troopsDetailHeader fromHeader">
				<i class="attack colorIcon"></i>
				<span translate>RallyPoint.SendTroops.ChooseTroops</span>
			</div>
			<div troops-details troop-data="troopDetails" unit-input-callback="checkTroops"></div>
		</div>
	</div>
</div>

<div class="buttonContainer">
	<button ng-class="{disabled: totalTroopCount == 0}"
			class="jsButtonSendTroopsBack"
			clickable="moveTroopsHome();">
		<span translate options="{{moveHomeType}}">Troops.?Back</span>
	</button>
</div>

</script>
<script type="text/ng-template" id="tpl/sendTroops/SendTroopsSelect.html"><div class="minHeightContainer">
	<div class="contentBox colored choose-troops">
		<div class="contentBoxBody">
			<search-village class="chooseTarget"
							check-target-fct="checkTargetSend"
							callback="preselectAndCheckTarget"
							api="villageSearch"
							show-duration="{{showDuration}}"
							show-distance="{{!showDuration}}"
							show-own-villages="true"></search-village>

			<div class="contentBox chooseMissionType">
				<h6 class="contentBoxHeader headerWithIcon arrowDirectionTo">
					<i class="attack colorIcon"></i>
					<span translate>RallyPoint.SendTroops.Type</span>
				</h6>
				<div class="contentBoxBody">
					<div ng-repeat="type in missionTypes"
						 clickable="selectMovementType({{type.id}})"
						 class="clickableContainer missionType{{type.id}}"
						 ng-class="{active: type.state == 'selected', disabled: type.state == 'deactivated'}"
						 ng-show="type.state != 'hidden'"
						 tooltip
						 tooltip-translate-switch="{
								'RallyPoint.SendTroops.Type_{{type.name}}' : {{!type.disabledBySitter}},
								'Sitter.DisabledAsSitter': {{type.disabledBySitter == 'disabledBySitter'}},
								'Sitter.DisabledAsSitterVsHuman': {{type.disabledBySitter == 'disabledBySitterVsHuman'}}
								}"
						 tooltip-data="SpyName: {{spyName}}"
						 tooltip-placement="top">
						<i class="missionType"
						   ng-class="{
								disabled: type.state == 'deactivated',
								sendTroops_attack_large_illu: type.id == Troops.MOVEMENT_TYPE_ATTACK,
								sendTroops_raid_large_illu: type.id == Troops.MOVEMENT_TYPE_RAID,
								sendTroops_support_large_illu: type.id == Troops.MOVEMENT_TYPE_SUPPORT,
								sendTroops_spy_large_illu: type.id == Troops.MOVEMENT_TYPE_SPY,
								sendTroops_settle_large_illu: type.id == Troops.MOVEMENT_TYPE_SETTLE,
								sendTroops_siege_large_illu: type.id == Troops.MOVEMENT_TYPE_SIEGE
						   }"></i>
					</div>
				</div>
				<div class="contentBoxBody">
					<div ng-repeat="type in newMissionTypes"
						 clickable="selectMovementType({{type.id}})"
						 class="clickableContainer missionType{{type.id}}"
						 ng-class="{active: type.state == 'selected', disabled: type.state == 'deactivated'}"
						 tooltip
						 tooltip-translate="RallyPoint.SendTroops.Type_{{type.name}}"
						 tooltip-data="SpyName: {{spyName}}"
						 tooltip-placement="top">
						<div class="missionType type_{{type.id}}"></div>
						<i></i>
					</div>
				</div>
			</div>

			<div class="troopsDetailContainer chooseUnits">
				<div class="troopsDetailHeader fromHeader">
					<i class="attack colorIcon"></i>
					<span translate>RallyPoint.SendTroops.ChooseTroops</span>
					<div class="troopsInfo">
						<div dropdown data="villageDropdown">{{option.name}}</div>
					</div>
				</div>
				<div troops-details troop-data="troopDetails" unit-input-callback="checkTroops"></div>
			</div>
		</div>
	</div>
</div>
<div class="error" ng-show="error != null && error != ''" ng-bind-html="error"></div>

<div class="buttonContainer">
	<button class="next" ng-class="{disabled: villageSearch.target == null || totalTroopCount <= 0 || error || input.movementType == null}" clickable="checkTargetSend(1)">
		<span translate>Next</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/sendTroops/sendTroops.html"><div ng-controller="sendTroopsCtrl">

	<nav class="tabulation maintab">
		<a class="tab"
		   clickable="selectTab('{{tab.tabNr}}')"
		   ng-repeat="tab in sendTabs"
		   ng-class="{active: tab.tabNr == activeTab, inactive: tab.tabNr != activeTab}">
			<div class="content">
				{{tab.tabName}}
			</div>
			<i class="deleteTab"
			   ng-class="{action_cancel_tiny_flat_black: !cancelHover, action_cancel_tiny_flat_red: cancelHover}"
			   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"
			   clickable="closeTab('{{tab.tabNr}}')"></i>
		</a>
		<a class="tab inactive" clickable="addTab()" ng-if="showMoreTabs">
			<div class="content">
				<i class="symbol_plus_tiny_flat_black"></i>
			</div>
		</a>
	</nav>

	<div ng-repeat="tab in sendTabs" visible-tab-update="{{tab.tabNr}}" scrollable height-dependency="max" class="tabulationContent">
		<div ng-include="currentPage" class="send-troops" ng-controller="sendTroopsTabCtrl">
		</div>
	</div>

</div></script>
<script type="text/ng-template" id="tpl/society/society.html"><div class="society" ng-controller="societyCtrl">
    <div ng-include="tabBody"></div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/Diplomacy.html"><div ng-controller="allianceDiplomacyCtrl" class="diplomacy">
	<h6 class="headerWithIcon arrowDirectionDown">
		<i class="community_alliance_medium_flat_black"></i>
		{{alliance.data.name}}
	</h6>

	<div class="contentWrapper" scrollable height-dependency="max">
		<div class="category">
			<table>
				<thead>
				<tr>
					<th colspan="3" translate>Alliance.Diplomacy.OpenTreaties</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="i in alliance.data.diplomacy.foreignOffers">
					<td>
						<alliance-link allianceId="{{i.otherAllianceId}}" allianceName="{{i.otherAllianceTag}}"></alliance-link>
					</td>
					<td>
						<span options="{{i.type}}" translate>Alliance.Diplomacy.ReceivedOffer_?</span>
					</td>
					<td class="buttonContainer">
						<button clickable="acceptTreaty('{{i.id}}')" ng-if="!isSitter">
							<span translate options="{{i.type}}">
								Alliance.Diplomacy.ReceivedOffer.Button.Accept_?
							</span>
						</button>
						<button class="cancel" clickable="deleteTreaty('{{i.id}}')" ng-if="!isSitter">
							<span translate options="{{i.type}}">
								Alliance.Diplomacy.ReceivedOffer.Button.Decline_?
							</span>
						</button>
					</td>
				</tr>
				<tr ng-repeat="i in alliance.data.diplomacy.ownOffers">
					<td>
						<alliance-link allianceId="{{i.otherAllianceId}}" allianceName="{{i.otherAllianceTag}}"></alliance-link>
					</td>
					<td>
						<span options="{{i.type}}" data="date: {{i.offered}}" translate>Alliance.Diplomacy.OfferSent_?</span>
					</td>
					<td class="buttonContainer">
						<button class="cancel" clickable="deleteTreaty('{{i.id}}')" ng-if="!isSitter">
							<span translate>Alliance.Diplomacy.OfferSent.Button.Cancel</span>
						</button>
					</td>
				</tr>
				<tr ng-if="alliance.data.diplomacy.ownOffers.length == 0 && alliance.data.diplomacy.foreignOffers.length == 0">
					<td colspan="3" translate>Alliance.Diplomacy.NoDiplomacyOffers</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="category">
			<table>
				<thead>
				<tr>
					<th colspan="2" translate>Alliance.Diplomacy.BNDs</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="i in treaties[TYPE.BND]">
					<td>
						<alliance-link allianceId="{{i.otherAllianceId}}" allianceName="{{i.otherAllianceTag}}"></alliance-link>
					</td>
					<td class="buttonContainer">
						<button class="cancel" clickable="cancelTreaty('{{i.id}}')" ng-if="!isSitter">
							<span translate>Alliance.Diplomacy.Treaty.Button.Cancel</span>
						</button>
					</td>
				</tr>
				<tr ng-if="treaties[TYPE.BND] == 0">
					<td colspan="2" translate>Alliance.Diplomacy.NoBND</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="category">
			<table>
				<thead>
				<tr>
					<th colspan="2" translate>Alliance.Diplomacy.NAPs</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="i in treaties[TYPE.NAP]">
					<td>
						<alliance-link allianceId="{{i.otherAllianceId}}" allianceName="{{i.otherAllianceTag}}"></alliance-link>
					</td>
					<td class="buttonContainer">
						<button class="cancel" clickable="cancelTreaty('{{i.id}}')" ng-if="!isSitter">
							<span translate>Alliance.Diplomacy.Treaty.Button.Cancel</span>
						</button>
					</td>
				</tr>
				<tr ng-if="treaties[TYPE.NAP] == 0">
					<td colspan="2" translate>Alliance.Diplomacy.NoNAP</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="category">
			<table>
				<thead>
				<tr>
					<th colspan="2" translate>Alliance.Diplomacy.Wars</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="i in treaties[TYPE.WAR]">
					<td>
						<alliance-link allianceId="{{i.otherAllianceId}}" allianceName="{{i.otherAllianceTag}}"></alliance-link>
					</td>
					<td class="buttonContainer">
						<button class="cancel" clickable="cancelTreaty('{{i.id}}')" ng-if="!isSitter">
							<span translate>Alliance.Diplomacy.Treaty.Button.Cancel</span>
						</button>
					</td>
				</tr>
				<tr ng-if="treaties[TYPE.WAR] == 0">
					<td colspan="2" translate>Alliance.Diplomacy.NoWAR</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="buttonFooter">
			<div class="error">{{treatyAcceptError}}</div>
			<button clickable="openOverlay('allianceOfferTreaty');" ng-if="!isSitter">
				<span translate>Alliance.Diplomacy.Button.OfferTreaty</span>
			</button>
			<button class="disabled"
					tooltip
					tooltip-translate="Sitter.DisabledAsSitter"
					ng-if="isSitter">
				<span translate>Alliance.Diplomacy.Button.OfferTreaty</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/Intern.html"><div class="intern" ng-controller="allianceInternCtrl">
	<h6 class="headerWithIcon arrowDirectionDown ng-binding"><i class="community_alliance_medium_flat_black"></i><span>{{alliance.data.name}}</span></h6>

	<div class="statistics contentBox gradient">
		<h6 class="contentBoxHeader headerWithArrowEndings glorious">
			<div class="content" translate>Alliance.Intern.Statistics</div>
		</h6>
		<div class="contentBoxBody">
			<div class="statsBox attack contentBox colored contentBoxBody"
				 tooltip
				 tooltip-translate="Alliance.Intern.AttackPower">
				<i class="alliance_totalOffense_medium_illu"></i>
				<div class="absoluteValue lastDay">{{offStrength.lastDay|number:0}}</div>
				<div class="rankValue" translate data="rank:{{offRank|rank}}">Alliance.Intern.StrengthRank</div>
			</div>
			<div class="statsBox defense contentBox colored contentBoxBody"
				 tooltip
				 tooltip-translate="Alliance.Intern.DefensePower">
				<i class="alliance_totalDefense_medium_illu"></i>
				<div class="absoluteValue lastDay">{{defStrength.lastDay|number:0}}</div>
				<div class="rankValue" translate data="rank:{{defRank|rank}}">Alliance.Intern.StrengthRank</div>
			</div>
		</div>
	</div>

	<div ng-show="treaties.length > 0" class="diplomacy contentBox gradient">
		<h6 class="contentBoxHeader headerWithArrowEndings glorious">
			<div class="content" translate>Tab.Diplomacy</div>
		</h6>
		<div class="contentBoxBody" scrollable>
			<table class="transparent">
				<tbody>
					<tr ng-repeat="i in treaties">
						<td class="colorCol"><span class="markerColor" ng-style="{{i.colorData.cssStyle}}"></span></td>
						<td>
							<span options="{{i.type}}" data="victimId: {{i.otherAllianceId}}, victimName: {{i.otherAllianceTag}}" translate>Alliance.Intern.Diplomacy.Type_?</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="internalInfos contentBox colored" ng-class="{'diplomacyBlockShown': treaties.length > 0}">
		<div class="contentBoxHeader">
			<span translate>Alliance.Intern.InternalInfos</span>
			<i ng-if="hasRight('RIGHT_EDIT_PROFILE') && !isSitter"
			   class="headerButton"
			   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
			   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
			   clickable="openOverlay('allianceEditInternalInfo');"></i>
		</div>
		<div class="contentBoxBody" scrollable ng-class="{'visible': descriptionVisible}">
			<div user-text-parse="alliance.data.description.internalInfos1" parse="decorations"></div>
		</div>
	</div>

	<div class="newsFeed contentBox gradient">
		<h6 class="contentBoxHeader headerWithArrowEndings glorious">
			<div class="content" translate>Alliance.Intern.NewsFeed</div>
		</h6>
		<div class="contentBoxBody">
			<div pagination items-per-page="itemsPerPage"
						number-of-items="numberOfItems"
						current-page="currentPage"
						display-page-func="displayCurrentPage"
						route-named-param="cp">
				<table class="columnOnly">
					<tr ng-repeat="n in news">
						<td>
							<span options="{{n.type}}" data="agentId: {{n.agentId}}, agentName: {{n.agentName}}, victimId: {{n.victimId}}, victimName: {{n.victimName}}" translate>Alliance.News.Type_?</span>
						</td>
						<td>
							<span i18ndt="{{n.time}}" format="short"></span>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/Members.html"><div class="memberlist" ng-controller="allianceMembersCtrl">
	<h6 class="headerWithIcon arrowDirectionDown" ng-class="{availablePromotion: myself.offeredRights > 0}">
		<i class="community_alliance_medium_flat_black"></i>
		{{alliance.data.name}}
		<a clickable="openOverlay('allianceAcceptRights');"
		   class="invitations" ng-if="myself.offeredRights > 0">
			<span translate>Alliance.PromotionAvailable</span>
			<i class="community_invitation_small_illu"></i>
		</a>

		<span ng-if="canInvite && invitations.data.length > 0" class="invitations">
			<a href="" clickable="openOverlay('allianceOpenInvitations');">
				<span translate data="cnt: {{invitations.data.length}}">Group.OpenInvitations</span>
				<i class="community_invitation_small_illu"></i>
			</a>
		</span>
	</h6>

	<div class="contentWrapper" scrollable height-dependency="max">
		<div class="members contentBox gradient">
			<h6 class="contentBoxHeader headerWithArrowEndings">
				<div class="content" translate>
					Alliance.Members.Members
				</div>
			</h6>
			<div class="contentBoxBody">
				<div pagination display-page-func="displayCurrentPage"
							startup-position="{{ownPosition}}"
							items-per-page="itemsPerPage"
							number-of-items="numberOfItems"
							current-page="currentPage"
							route-named-param="cp">
					<table class="memberTable">
						<thead>
							<tr class="member">
								<th translate colspan="2">TableHeader.Player</th>
								<th></th>
								<th class="villages"><i class="village_village_small_flat_black" tooltip tooltip-translate="Villages"></i></th>
								<th class="population"><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="m in members"
								class="member"
								on-pointer-over="showOptions(m.playerId)"
								on-pointer-out="hideOptions()"
								ng-class="{highlighted: (m.rank - 1) == ownPosition}">
								<td class="rank">
									{{m.rank}}.
								</td>
								<td class="playerName">
									<div class="longTitle">
										<online-status text="Alliance.Role_{{m.allianceRights}}"
													   icon-class="community_{{roles[m.allianceRights]}}_small_flat"
													   status="{{m.chatUser.data.lastClick}}"
													   is-online="{{m.chatUser.data.online}}"></online-status>
										<i class="symbol_star_tiny_illu" ng-if="m.offeredRights > 0"></i>
										<span player-link playerId="{{m.playerId}}" playerName="{{m.name}}"></span>
									</div>
									<div class="options"
										 ng-if="m.kingdomId == m.playerId && showOptionOn == m.playerId && canGrant && !isSitter" on-pointer-over="showOptions(m.playerId)"
										 tooltip tooltip-translate="Alliance.Members.Options.Dropdown.Tooltip" tooltip-placement="above"
										 more-dropdown more-dropdown-options="getOptions({{m.playerId}})"></div>
								</td>
								<td class="attack">
									<i ng-if="attackedGovernors[m.playerId]"
									   class="movement_attack_small_flat_red"
									   tooltip
									   tooltip-url="tpl/society/partials/kingdom/governorAttackTooltip.html"></i>
								</td>
								<td class="villages">
									<span class="content">{{ m.villages }}</span>
								</td>
								<td class="population">
									<span class="content">{{ m.population|number:0}}</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="contentBox gradient playerOfTheWeek">
			<h6 class="contentBoxHeader headerWithArrowEndings glorious">
				<div class="content" translate>
					Alliance.Members.PlayersOfTheWeek
				</div>
			</h6>
			<div class="contentBoxBody">
				<table class="memberTable">
					<thead>
						<tr class="allianceMembersPlayerOfTheWeek">
							<th colspan="3" class="firstRow">
								<i class="movement_attack_small_flat_black"></i>
								<span class="header"
									  translate
									  tooltip
									  tooltip-url="tpl/society/partials/alliance/top10tooltip.html"
									  tooltip-data="type:Attacker">
									Attacker</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="i in [0, 1, 2]">
							<td class="rank">{{ i + 1 }}.</td>
							<td class="nameColumn">
								<div ng-if="alliance.stats.top10Attacker[i]">
									<online-status text="Alliance.Role_{{alliance.stats.top10Attacker[i].rights}}"
												   icon-class="community_{{roles[alliance.stats.top10Attacker[i].rights]}}_small_flat"
												   status="{{alliance.stats.top10Attacker[i].chatUser.data.lastClick}}"
												   is-online="{{alliance.stats.top10Attacker[i].chatUser.data.online}}"></online-status>
									<span player-link playerId="{{alliance.stats.top10Attacker[i].playerId}}" playerName="{{alliance.stats.top10Attacker[i].name}}"></span>
								</div>
								<div ng-if="!alliance.stats.top10Attacker[i]">
									-
								</div>
							</td>
							<td>
								<div ng-if="alliance.stats.top10Attacker[i]">
									{{alliance.stats.top10Attacker[i].points}}
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<table>
					<thead>
						<tr>
							<th colspan="3">
								<i class="movement_defend_small_flat_black"></i>
								<span class="header"
									  translate
									  tooltip
									  tooltip-url="tpl/society/partials/alliance/top10tooltip.html"
									  tooltip-data="type:Defender">
									Defender</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="i in [0, 1, 2]">
							<td class="rank">{{ i + 1 }}.</td>
							<td class="nameColumn">
								<div ng-if="alliance.stats.top10Defender[i]">
									<online-status text="Alliance.Role_{{alliance.stats.top10Defender[i].rights}}"
												   icon-class="community_{{roles[alliance.stats.top10Defender[i].rights]}}_small_flat"
												   status="{{alliance.stats.top10Defender[i].chatUser.data.lastClick}}"
												   is-online="{{alliance.stats.top10Defender[i].chatUser.data.online}}"></online-status>
									<span player-link playerId="{{alliance.stats.top10Defender[i].playerId}}" playerName="{{alliance.stats.top10Defender[i].name}}"></span>
								</div>
								<div ng-if="!alliance.stats.top10Defender[i]">
									-
								</div>
							</td>
							<td>
								<div ng-if="alliance.stats.top10Defender[i]">
									{{alliance.stats.top10Defender[i].points}}
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<table>
					<thead>
						<tr>
							<th colspan="3">
								<i class="ranking_climber_small_flat_black"></i>
								<span class="header"
									  translate
									  tooltip
									  tooltip-url="tpl/society/partials/alliance/top10tooltip.html"
									  tooltip-data="type:Climber">
									Climber</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="i in [0, 1, 2]">
							<td class="rank">{{ i + 1 }}.</td>
							<td class="nameColumn">
								<div ng-if="alliance.stats.top10Climber[i]">
									<online-status text="Alliance.Role_{{alliance.stats.top10Climber[i].rights}}"
												   icon-class="community_{{roles[alliance.stats.top10Climber[i].rights]}}_small_flat"
												   status="{{alliance.stats.top10Climber[i].chatUser.data.lastClick}}"
												   is-online="{{alliance.stats.top10Climber[i].chatUser.data.online}}"></online-status>
									<span player-link playerId="{{alliance.stats.top10Climber[i].playerId}}" playerName="{{alliance.stats.top10Climber[i].name}}"></span>
								</div>
								<div ng-if="!alliance.stats.top10Climber[i]">
									-
								</div>
							</td>
							<td>
								<div ng-if="alliance.stats.top10Climber[i]">
									{{alliance.stats.top10Climber[i].points}}
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="buttonFooter" ng-if="canInvite">
		<button clickable="openOverlay('allianceInvite');" ng-if="!isSitter">
			<span translate>Alliance.Members.Button.Invite</span>
		</button>
		<button class="disabled"
				tooltip
				tooltip-translate="Sitter.DisabledAsSitter"
				ng-if="isSitter">
			<span translate>Alliance.Members.Button.Invite</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/Profile.html"><div ng-controller="allianceProfileCtrl" class="profile">
	<h6 class="contentBoxHeader headerWithIcon arrowDirectionDown">
		<i class="community_alliance_medium_flat_black"></i>
		{{alliance.data.name}}
		<i ng-if="hasRight('ROLE_LEADER') && !isSitter"
		   class="headerButton"
		   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
		   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
		   clickable="openOverlay('allianceChangeName')"
		   tooltip tooltip-translate="Button.Edit"></i>
	</h6>

	<div class="allianceStats contentBox gradient">
		<div class="contentBoxBody">
			<div></div>
			<div class="allianceRank">
				<div class="rank"><span translate>Alliance.Profile.Rank</span>
					<span ng-if="alliance.data.victoryPointsRank>=0 && alliance.data.victoryPoints>0">{{alliance.data.victoryPointsRank|rank}}</span>
					<span ng-if="alliance.data.victoryPointsRank<0 || alliance.data.victoryPointsRank == null || alliance.data.victoryPoints<=0">-</span>
				</div>
				<div class="score"><span translate>Alliance.Profile.Victorypoints</span> {{alliance.data.victoryPoints}}
				</div>
			</div>
			<table class="statisticsTable transparent">
				<tr>
					<th><span translate>Alliance.Profile.Members</span>:</th>
					<td>{{alliance.data.members.length}}</td>
				</tr>
				<tr>
					<th><span translate>Alliance.Profile.Villages</span>:</th>
					<td>{{totalVillages}}</td>
				</tr>
				<tr>
					<th><span translate>Alliance.Profile.Populationpoints</span>:</th>
					<td>{{alliance.data.points|number:0}}</td>
				</tr>
				<tr ng-if="worldWonderLvl != null">
					<th><span translate>Alliance.Profile.WorldWonder</span>:</th>
					<td><span translate>Alliance.Profile.Lvl</span>: {{worldWonderLvl}}</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="kingdomStats contentBox gradient">
		<h6 class="contentBoxHeader headerWithArrowEndings glorious">
			<div class="content" translate>Alliance.Profile.KingdomsHeader</div>
		</h6>
		<div class="contentBoxBody">
			<table class="kingdomsTable">
				<thead>
					<tr>
						<th translate>Alliance.Profile.Kings</th>
						<th class="villagesCol"><i class="village_village_small_flat_black" tooltip tooltip-translate="Villages"></i></th>
						<th class="populationCol"><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="kingdom in kingdomStats" ng-class="{highlighted: kingdom.kingId == ownKingdomId}">
						<td>
							<span player-link playerId="{{kingdom.kingId}}" playerName="{{kingdom.kingName}}"></span>
						</td>
						<td class="villagesCol">{{kingdom.villages}}</td>
						<td class="populationCol">{{kingdom.population|number:0}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="allianceDescription contentBox">
		<div class="contentBoxHeader">
			<div class="headerText" translate>Alliance.Profile.Description</div>
			<i ng-if="hasRight('RIGHT_EDIT_PROFILE') && !isSitter"
			   class="headerButton"
			   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
			   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
			   clickable="openOverlay('allianceEditDescription', {'allianceId': alliance.data.groupId})"
			   tooltip tooltip-translate="Button.Edit"></i>
		</div>
		<div class="contentBoxBody" scrollable>
			<div class="description" user-text-parse="alliance.data.description.column1" parse="decorations"></div>
			<div class="description" user-text-parse="alliance.data.description.column2" parse="decorations"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/acceptRights.html"><div class="inWindowPopup allianceInvite"
	 ng-class="{warning: overlayConfig['isAWarning']}">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div class="acceptRightsQuestion" translate>Alliance.AcceptRightsQuestion</div>
		<button class="replyButton" clickable="replyToRightOffer(1)">
			<span translate>Button.Accept</span>
		</button>
		<button class="replyButton cancel" clickable="replyToRightOffer(0)">
			<span translate>Button.Decline</span>
		</button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/partials/alliance/changeName.html"><div ng-controller="allianceChangeNameCtrl">
	<h6 class="headerColored">
		<span translate>Alliance.Name</span>
		<span class="allianceTag" translate>Alliance.Tag</span>
	</h6>

	<div class="inputContainer">
		<input class="text" type="text" maxlength="20" ng-model="newName" placeholder="{{placeHolderAllianceName}}">
		<input class="text allianceTag" maxlength="8" type="text" ng-model="newTag" placeholder="{{placeHolderAllianceTag}}">
	</div>


	<div class="buttonFooter">
		<div class="error" ng-if="allianceNameError">{{allianceNameError}}</div>
		<button clickable="renameAlliance()" ng-class="{disabled: !newTag || !newName}">
			<span translate>Alliance.Button.Rename</span>
		</button>
		<button clickable="closeOverlay();" class="cancel">
			<span translate>Alliance.Button.Cancel</span>
		</button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/changeRights.html"><div class="inWindowPopup allianceChangeRights"
	 ng-class="{warning: overlayConfig['isAWarning']}">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<h6 class="headerColored">
			<span ng-if="!member.isKing" translate>Alliance.ChangeRights.GovernorHeadline</span>
			<span ng-if="member.isKing" translate>Alliance.ChangeRights.KingHeadline</span>
			<span player-link playerId="{{member.playerId}}" playerName="{{member.name}}"></span>
		</h6>
		<!-- rights for kings -->
		<div ng-if="member.isKing">
			<a class="clickableContainer" clickable="setRole({{role.KING}});" ng-class="{'active': newRole == role.KING}">
				<div class="column">
					<h5 translate>Alliance.ChangeRights.Option.Basic.Headline</h5>
				</div>
				<div class="column">
					<ul translate>Alliance.ChangeRights.Option.KingBasic.Description</ul>
				</div>
				<div class="verticalLine double"></div>
			</a>
			<a class="clickableContainer" clickable="setRole({{role.TRUSTEE}});" ng-class="{'active': newRole == role.TRUSTEE}">
				<div class="column">
					<h5 translate>Alliance.ChangeRights.Option.Trustee.Headline</h5>
				</div>
				<div class="column">
					<ul translate>Alliance.ChangeRights.Option.Trustee.Description</ul>
				</div>
				<div class="verticalLine double"></div>
			</a>
			<a class="clickableContainer" clickable="setRole({{role.LEADER}});" ng-class="{'active': newRole == role.LEADER}">
				<div class="column">
					<h5 translate>Alliance.ChangeRights.Option.Leader.Headline</h5>
				</div>
				<div class="column">
					<ul translate>Alliance.ChangeRights.Option.Leader.Description</ul>
				</div>
				<div class="verticalLine double"></div>
			</a>
		</div>

		<div class="buttonFooter">
			<div class="error">{{allianceChangeRightsError}}</div>
			<button clickable="changeRole();">
				<span translate>Alliance.ChangeRights.Button.Accept</span>
			</button>
			<button clickable="closeOverlay();" class="cancel">
				<span translate>Button.Abort</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/editDescription.html"><div ng-controller="allianceEditDescriptionCtrl" class="alliance allianceEditDescription">
<h6 class="headerColored" translate>Alliance.EditDescription.Description</h6>

	<div class="allianceDescription contentBox colored">
		<div class="contentBoxBody" scrollable>
			<textarea class="description editDescription" maxlength="2000" ng-model="$parent.description1" auto-focus="resetCursor"></textarea>
			<textarea class="description editDescription" maxlength="2000" ng-model="$parent.description2"></textarea>
		</div>
	</div>
	<div class="buttonFooter">
		<div class="error">{{allianceChangeDescriptionError}}</div>
		<button clickable="editDescription();">
			<span translate>Alliance.EditDescription.Button.Accept</span>
		</button>
		<button clickable="closeOverlay();" class="cancel">
			<span translate>Button.Abort</span>
		</button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/partials/alliance/editInternalInfo.html"><div class="internalInfos contentBox colored">
	<div class="contentBoxBody">
		<textarea ng-model="$parent.description.internalInfos1"></textarea>
	</div>
</div>

<div class="buttonFooter">
	<button clickable="editInfos()">
		<span translate>Alliance.EditInternalInfo.Button.Accept</span>
	</button>
	<button clickable="closeOverlay()" class="cancel">
		<span translate>Button.Abort</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/incomingAttackTooltip.html"><h3 translate>Alliance.Members.NextAttack</h3>
<div class="horizontalLine"></div>
{{village}}: <span i18ndt="{{time}}" format="mediumTime"></span></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/invite.html"><div class="inWindowPopup allianceInvite"
	 ng-class="{warning: overlayConfig['isAWarning']}">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div class="contentBox transparent">
			<h6 class="contentBoxHeader headerColored" translate>
				Alliance.Invite.Name
			</h6>

			<div class="contentBoxBody">
				<serverautocomplete autocompletedata="king" autocompletecb="selectInvitePlayer" ng-model="invitePlayer" auto-focus-after-select=".allianceInvite .message"></serverautocomplete>
			</div>
		</div>
		<div class="contentBox transparent">
			<h6 class="contentBoxHeader headerColored" translate>
				Alliance.Invite.OptionalMessage
			</h6>

			<div class="contentBoxBody">
				<textarea class="message" maxlength="2000" ng-model="input.customText"></textarea>
			</div>
		</div>
		<div class="buttonFooter">
			<button clickable="invite();" ng-class="{'disabled':!selectedPlayer || selectedPlayer == null}">
				<span translate>Alliance.Invite.Button.Accept</span>
			</button>
			<button clickable="closeOverlay();" class="cancel">
				<span translate>Button.Abort</span>
			</button>
			<div class="error">{{allianceInviteError}}</div>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/partials/alliance/kickMember.html"><div class="contentBox transparent">
	<h6 class="contentBoxHeader headerColored">
		<span player-link playerId="{{player.data.playerId}}" playerName="{{player.data.name}}"></span>
	</h6>
	<div class="contentBoxBody">
		<p translate data="victoryPoints:{{memberVictoryPoints}}">Alliance.KickMember.Warning</p>
		<p translate>Alliance.KickMember.PasswordDisclaimer</p>
		<div ng-if="!useMellon">
			<span><span translate>Password</span>:</span>
			<input type="password" ng-model="kick.password">
		</div>
	</div>
	<div class="buttonFooter">
		<div class="error">{{allianceKickMemberError}}</div>
		<button ng-if="!useMellon" clickable="kickMember()"><span translate>Alliance.KickMember.Button.Accept</span></button>
		<button ng-if="useMellon" clickable="confirmWithPassword()"><span translate>Alliance.KickMember.Button.Accept</span></button>
		<button clickable="closeOverlay();" class="cancel"><span translate>Button.Abort</span></button>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/alliance/offerTreaty.html"><div class="inWindowPopup"
	 ng-class="{warning: overlayConfig['isAWarning']}">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent">
		<div class="contentBox transparent">
			<h6 class="contentBoxHeader headerColored" translate>
				Alliance.Diplomacy.OfferTreaty.AllianceName
			</h6>

			<div class="contentBoxBody">
				<serverautocomplete autocompletedata="alliance" autocompletecb="searchCallback" ng-model="targetInput"></serverautocomplete>
			</div>
		</div>
		<div class="horizontalLine"></div>
		<div class="contentBox transparent offerType">
			<div class="contentBoxHeader" translate>
				Alliance.Diplomacy.OfferTreaty.TreatyType
			</div>
			<div class="contentBoxBody">
				<div class="offerLabel">
					<label>
						<input type="radio" name="treatyType" ng-model="input.selectedTreaty" value="2">
						<span translate>Alliance.Diplomacy.War</span>
					</label>
				</div>
				<div class="offerLabel">
					<label>
						<input type="radio" name="treatyType" ng-model="input.selectedTreaty" value="0">
						<span translate>Alliance.Diplomacy.NAP</span>
					</label>
				</div>
				<div class="offerLabel">
					<label>
						<input type="radio" name="treatyType" ng-model="input.selectedTreaty" value="1">
						<span translate>Alliance.Diplomacy.BND</span>
					</label>
				</div>
			</div>
		</div>
		<div class="buttonFooter">
			<div class="error">{{allianceTreatyError}}</div>
			<button clickable="offerTreaty();" ng-class="{'disabled':((!selectedAlliance) || (input.selectedTreaty < 0))}">
				<span translate>Alliance.Diplomacy.OfferTreaty.Button.Accept</span>
			</button>
			<button class="cancel" clickable="closeOverlay();">
				<span translate>Button.Abort</span>
			</button>
		</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/partials/alliance/openInvitations.html"><div class="inWindowPopup allianceInvite">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent openInvitations">
		<div pagination class="paginated"
					items-per-page="itemsPerPage"
					number-of-items="numberOfItems"
					current-page="currentPage"
					display-page-func="displayCurrentPage"
					route-named-param="cp2">
			<table>
				<tbody>
				<tr ng-repeat="invite in rows">
					<td class="nameColumn">
						<span player-link playerId="{{invite.data.playerId}}" playername="{{invite.data.playerName}}"></span>
					</td>
					<td class="invitationDate"><span i18ndt="{{invite.data.invitationTime}}" format="short"></span></td>
					<td class="close">
						<i ng-if="!isSitter" ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="revokeInvitation({{invite.data.id}});"
						   tooltip tooltip-translate="Group.RevokeInvitation"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"></i>
					</td>
				</tr>
				<tr ng-if="invitations.data.length == 0">
					<td colspan="3" translate>Group.NoOpenInvitations</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="error">{{allianceInviteRevokeError}}</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/partials/alliance/top10tooltip.html"><h3>
	<span translate options="{{type}}">?</span>
	<span translate>Tab.Top10</span>
</h3>
<div ng-repeat="(key, value) in alliance.stats" ng-show="key == 'top10'+type" class="top10">
	<div class="horizontalLine" ng-show="value"></div>
	<table class="transparent">
		<tr ng-repeat="item in value">
			<td>{{item.rank+1}}.</td>
			<td>{{item.name}}</td>
			<td>{{item.points}}</td>
		</tr>
	</table>
</div>
<div class="horizontalLine"></div>
<div class="top10">
	<table class="transparent">
		<tr ng-if="ownRanks['top10'+type]">
			<td>{{ownRanks['top10'+type].rank+1}}.</td>
			<td>{{ownRanks['top10'+type].name}}</td>
			<td>{{ownRanks['top10'+type].points}}</td>
		</tr>
		<tr ng-if="!ownRanks['top10'+type]">
			<td colspan="3">?</td>
		</tr>
	</table>
</div>


</script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/Info.html"><div class="infos" ng-controller="kingdomInformationCtrl">
	<div class="scrollWrapper" scrollable scrolling-disabled="{{king == null}}" ng-class="{noking: king == null}">
		<h6 ng-if="king != null" class="headerWithIcon arrowDirectionDown">
			<i class="community_kingdom_medium_flat_black"></i>
			<span translate>Tab.Info</span>
		</h6>
		<div ng-if="king == null">
			<span translate>Kingdom.Information.NoKingdom</span>
		</div>
		<div ng-if="king != null" class="contentWrapper">
			<div class="dukeSlots contentBox">
				<div class="contentBoxHeader headerWithArrowEndings golden">
					<div class="content">
						<i class="unit_treasure_medium_illu" tooltip tooltip-translate="Resource.Treasures"></i> <span class="activeTreasures">{{treasures.data.treasuresCurrent|bidiNumber:'':false:false:false:true}}</span>
					</div>
				</div>
				<div class="contentBoxBody">
					<div class="kingPortraitWrapper">
						<div class="kingPortrait">
							<avatar-image player-id="{{king.data.playerId}}" avatar-class="profile kingdom-internal" no-shoulders="false"></avatar-image>
						</div>
					</div>
					<div class="dukeSlots">
						<div class="dukeSlotsHeader">
							<span translate class="text">Kingdom.Dukes.TableHeader.Dynasty</span>
							<span class="population"><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i></span>
							<span class="treasures"><i class="unit_treasure_small_flat_black" tooltip tooltip-translate="Resource.Treasures"></i></span>
						</div>
						<div class="dukeSlotsBody">
							<div class="king arrowContainer">
								<span class="arrowInside"><i class="community_kingdom_small_flat_black"></i></span>
								<span class="arrowOutside">
									<span player-link playerId="{{king.data.playerId}}" playerName="{{king.data.name}}"></span>
									<span class="population">{{king.data.population}}</span>
									<span class="treasures">{{king.treasures}}</span>
								</span>
							</div>

							<div ng-repeat="dukeSlot in dukeSlots" class="{{dukeSlot.type}}">
								<div class="arrowContainer arrowDirectionTo active" ng-if="dukeSlot.type == 'duke'">
									<span class="arrowInside">{{$index+1}}</span>
									<span class="arrowOutside">
										<span player-link playerId="{{dukeSlot.data.data.playerId}}" playerName="{{dukeSlot.data.data.name}}"></span>
										<span class="population">{{dukeSlot.data.data.population}}</span>
										<span class="treasures">{{dukeSlot.data.treasures}}</span>
										<span class="options" ng-if="player.data.isKing">
											<span class="optionContainer" clickable="dismissDuke({{dukeSlot.data.data.playerId}})"
												  tooltip tooltip-translate="Kingdom.Dukes.Slots.Tooltip.DismissDuke"
												  on-pointer-over="dismissHover = true" on-pointer-out="dismissHover = false">
												<i ng-class="{action_leave_small_flat_black: !dismissHover, action_leave_small_flat_red: dismissHover}"></i>
											</span>
										</span>
										<span class="options" ng-if="player.data.playerId == dukeSlot.data.data.playerId">
											<span class="optionContainer" clickable="dismissDuke(-1)"
												  tooltip tooltip-translate="Embassy.Communities.Kingdom.abdicateAsDuke"
												  on-pointer-over="abdicateHover = true" on-pointer-out="abdicateHover = false">
												<i ng-class="{action_leave_small_flat_black: !abdicateHover, action_leave_small_flat_red: abdicateHover}"></i>
											</span>
										</span>
									</span>
								</div>

								<div class="arrowContainer arrowDirectionTo inactive" ng-if="dukeSlot.type == 'invitation'">
									<span class="arrowInside">{{$index+1}}</span>
									<span class="arrowOutside">
										<span translate data="playerId:{{dukeSlot.data.data.playerId}}, playerName: {{dukeSlot.data.data.name}}">Kingdom.Dukes.Slots.Invited</span>
										<span class="options" ng-if="player.data.isKing">
											<span class="optionContainer" clickable="cancelDukeInvitation({{dukeSlot.data.data.id}})"
												  tooltip tooltip-translate="Kingdom.Dukes.Slots.Tooltip.cancelInvitation"
												  on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false">
												<i ng-class="{action_delete_small_flat_black: !cancelHover, action_delete_small_flat_red: cancelHover}"></i>
											</span>
										</span>
									</span>
								</div>

								<div class="arrowContainer arrowDirectionTo inactive" ng-if="dukeSlot.type == 'empty'">
									<span class="arrowInside">{{$index+1}}</span>
									<span class="arrowOutside">
										<div ng-if="player.data.isKing">
											<div class="symbol_i_tiny_wrapper">
												<i class="symbol_i_tiny_flat_white" tooltip tooltip-translate="Kingdom.Dukes.Slots.Tooltip.PromoteDuke.Description"></i>
											</div>
											<span translate>Kingdom.Dukes.Slots.PromoteDuke</span>
										</div>
										<span translate ng-if="!player.data.isKing">Kingdom.Dukes.Slots.AvailableSlot</span>
										<span class="options" ng-if="player.data.isKing">
											<span class="optionContainer" clickable="inviteDuke({{dukeSlot.data.data.id}})"
												  tooltip tooltip-translate="Kingdom.Dukes.Slots.Tooltip.PromoteDuke"
												  on-pointer-over="promoteHover = true" on-pointer-out="promoteHover = false">
												<i ng-class="{action_invite_small_flat_black: !promoteHover, action_invite_small_flat_green: promoteHover}"></i>
											</span>
										</span>
									</span>
								</div>

								<div class="arrowContainer arrowDirectionTo disabled locked firstLocked" ng-if="dukeSlot.type == 'locked'">
									<span class="arrowInside">{{$index+1}}</span>
									<span class="arrowOutside" ng-if="dukeSlot.data.firstElement">
										<div class="symbol_lock_small_wrapper">
											<i class="symbol_lock_small_flat_black"></i>
										</div>
										<span translate class="labelText" data="needed: {{dukeSlot.data.neededTreasures}}, current:{{treasures.data.treasuresCurrent}}">Kingdom.Dukes.Slots.TreasuresNeeded</span>
										<div progressbar perc="{{treasures.data.treasuresCurrent/dukeSlot.data.neededTreasures*100}}"></div>
									</span>
									<span class="arrowOutside" ng-if="!dukeSlot.data.firstElement">
										<div class="symbol_lock_small_wrapper">
											<i class="symbol_lock_small_flat_black"></i>
										</div>
										<span translate data="needed: {{dukeSlot.data.neededTreasures}}, current:{{dukeSlots[$index-1].data.neededTreasures}}">Kingdom.Dukes.Slots.TreasuresNeeded</span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="kingdomStatistics contentBox gradient">
				<div class="contentBoxBody">
					<div pagination class="paginated"
								display-page-func="prepareTreasureRank"
								current-page="treasureRank.currentPage"
								items-per-page="treasureRank.itemsPerPage"
								number-of-items="treasureRank.numberOfItems"
								startup-position="treasureRank.ownPosition"
								route-named-param="cp">
						<div class="treasureHeader" data="weeklyGain:{{treasures.data.treasuresCurrent - treasures.data.treasuresLatestWeek|bidiNumber:'':true:false:false:true}}" translate>
							Kingdom.Information.WeeklyRank
						</div>
						<table class="columnOnly treasureRanking">
							<tr ng-repeat="n in treasureRank.players" ng-class="{highlighted: n.playerId == player.data.playerId}">
								<td>
									<div class="heroPotraitCol">
										<avatar-image scale="0.5" player-id="{{n.playerId}}" avatar-class="profile kingdom-internal" ng-if="n.playerId > 0" no-shoulders="false"></avatar-image>
									</div>
								</td>
								<td class="playerInfos">
									<span class="name">{{n.rank + 1}}. <span player-link playerId="{{n.playerId}}" playerName="{{n.name}}"></span></span>
									<span class="treasures"><i class="unit_treasure_small_illu"></i> {{n.points|bidiNumber:'':true:false:false:true}}</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="taxRate contentBox gradient">
				<div class="contentBoxHeader">
					<span translate>Kingdom.Information.TaxRate</span> -
					<span options="{{stats.taxRate}}" translate>TaxRate._?</span>
					<span class="actions">
						<div class="taxInfo symbol_i_tiny_wrapper" ng-class="{noKing: !player.data.isKing}"
							 tooltip tooltip tooltip-class="kingdomTaxInfo" tooltip-url="tpl/society/partials/kingdom/TaxInfo.html">
							<i class="symbol_i_tiny_flat_white"></i>
						</div>
						<i class="headerButton" ng-if="player.data.isKing"
						   ng-class="{action_edit_small_flat_black: !editHover || accountAge < 7, action_edit_small_flat_green: editHover && accountAge >= 7, disabled: accountAge < 7}"
						   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
						   clickable="openOverlay('kingdomSetTaxRate');"
						   tooltip
						   tooltip-translate-switch="{
								'TaxRate.TaxChangeBlock': {{accountAge < 7}},
								'Kingdom.Governors.SetTaxRate.Headline': {{accountAge >= 7}}
							}"></i>
					</span>
				</div>
				<div class="contentBoxBody taxRateInfo">
					<span ng-if="player.data.isKing" data="taxRate: {{stats.taxRate}}" translate>TaxRate.King</span>
					<span ng-if="!player.data.isKing" options="{{stats.taxRate}}" translate>TaxRate.Governor._?</span>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/TaxInfo.html"><div class="currentVillage">{{activeVillage.data.name}}</div>
<div ng-if="activeVillage.hasActiveTreasury()">
	<div ng-if="player.data.isKing" translate>TaxInfo.KingMayCollect</div>
	<div ng-if="!player.data.isKing" translate>TaxInfo.NoKing</div>
</div>
<div ng-if="!activeVillage.hasActiveTreasury()">
	<div ng-if="activeVillage.data.belongsToKing == -1" translate>TaxInfo.KingNoTreasury</div>
	<div ng-if="activeVillage.data.belongsToKing == 0" translate>TaxInfo.NoKing</div>
	<div ng-if="activeVillage.data.belongsToKing > 0">
		<div translate data="kingId:{{activeVillage.data.belongsToKing}}" class="textLine">TaxInfo.TributesFor</div>
		<div class="horizontalLine"></div>
		<display-resources resources="activeVillage.getTributes()" treasures="activeVillage.data.tributeTreasures"></display-resources>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/Territory.html"><div class="territory" ng-controller="kingdomTerritoryCtrl">
	<h6 class="headerWithIcon arrowDirectionDown">
		<i class="community_kingdom_medium_flat_black"></i>
		<span translate>Tab.Territory</span>
	</h6>
	<div class="contentWrapper" scrollable height-dependency="max">
		<div class="contentBox">
			<div class="contentBoxBody">
				<div class="kingdomCellStats contentBox gradient" ng-repeat="village in kingdomData">
					<div class="villageDetails contentBoxBody">
						<div class="villageName" ng-show="!village.isDukeVillage">
							<span village-link villageId="{{village.villageId}}" villageName="{{village.villageName}}"></span>
						</div>
						<div class="villageName" ng-show="village.isDukeVillage">
							<span player-link playerId="{{village.playerId}}"></span> | <span village-link villageId="{{village.villageId}}" villageName="{{village.villageName}}"></span>
						</div>

						<div class="villageLevel" translate data="level: {{village.level}}, max: 4">
						Kingdom.Territory.Level
						</div>

						<div class="levelProgress"
							 tooltip
							 tooltip-url="tpl/society/partials/kingdom/influenceBarTooltip.html">
							<div progressbar ng-repeat="percentage in village.levelPerc"
										 perc='{{percentage}}'></div>
						</div>

						<div class="populationNumbers">
							<i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i>
							<span ng-if="village.populationForNextLevel < 10000">{{0 | bidiRatio:village.population:village.populationForNextLevel}}</span>
							<span ng-if="village.populationForNextLevel >= 10000">{{village.population}}</span>
						</div>

						<div ng-if="village.influence > 0">

							<div class="influenceNumbers"><span  tooltip tooltip-url="tpl/society/partials/kingdom/influenceCalculationTooltip.html">
								<i class="unit_influence_small_flat_black"></i> {{village.influence}}</span>
							</div>

							<div class="territoryMap"
								 tooltip
								 tooltip-class="territoryMapTooltip"
								 tooltip-url="tpl/society/partials/kingdom/influenceTooltip.html"
								 map-part villageid="{{village.villageId}}" size="{{village.size}}">
							</div>
						</div>
						<div ng-if="village.influence <= 0" class="warning">
							<i class="symbol_warning_tiny_flat_red"></i>
							<span translate>Kingdom.Territory.Influence.Warning</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/Tributes.html"><div ng-controller="kingdomTributesCtrl" class="tributes">
	<h6 class="headerWithIcon arrowDirectionDown">
		<i class="community_kingdom_medium_flat_black"></i>
		<span translate>Kingdom.TributeOverview</span>
	</h6>
	<div class="marginToScrollbar"></div>
	<div scrollable height-dependency="max" scrolling-disabled="{{(villages == null || villages.length == 0) || !activeVillage.hasActiveTreasury()}}">
		<table>
			<thead>
				<tr>
					<th class="nameColumn" translate>TableHeader.Governor</th>
					<th class="population"><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i></th>
					<th class="support"><i tooltip tooltip-translate="Kingdom.Governors.SupportTroops" class="movement_support_small_flat_black"></i></th>
					<th translate>Kingdom.TributeStorage</th>
					<th class="empty" colspan="3"></th>
				</tr>
			</thead>
			<tbody ng-if="(villages == null || villages.length == 0) && activeVillage.hasActiveTreasury()">
				<tr>
					<td colspan="5" translate>Embassy.NoGovernors</td>
				</tr>
			</tbody>
			<tbody ng-if="!activeVillage.hasActiveTreasury()">
				<tr>
					<td colspan="5" translate>Tributes.VillageNotGeneratingInfluence</td>
				</tr>
			</tbody>
			<tbody ng-repeat="playerVillages in playerToVillages | orderBy:'playerId':true" ng-if="activeVillage.hasActiveTreasury()">
				<tr ng-class="{evenRow: $index%2 == 0, oddRow: $index%2 == 1}">
					<td colspan="6">
						<span player-link playerId="{{players[playerVillages.playerId].data.playerId}}" playerName="{{players[playerVillages.playerId].data.name}}"></span>
					</td>
				</tr>
				<tr ng-repeat="village in playerVillages.villages" ng-class="{evenRow: $parent.$index%2 == 0, oddRow: $parent.$index%2 == 1}">
					<td class="nameColumn" ng-class="{attack: attackedGovernors[village.data.playerId].villages[village.data.villageId]}">
						<i ng-if="attackedGovernors[village.data.playerId].villages[village.data.villageId]" class="movement_attack_small_flat_red" tooltip tooltip-url="tpl/society/partials/kingdom/attackTooltip.html"></i>
						<span village-link villageId="{{village.data.villageId}}" villageName="{{village.data.name}}"></span>
					</td>
					<td class="population">{{village.data.population}}</td>
					<td class="support">
						<i class="movement_support_small_flat_black" ng-if="supportedTroops[village.data.villageId]" tooltip tooltip-url="tpl/society/partials/kingdom/supportTooltip.html"></i>
					</td>
					<td class="populationBarCell" tooltip tooltip-url="tpl/society/partials/kingdom/tributesProductionTooltip.html">
						<div ng-if="!(getTributesOnTheirWay(village.data.villageId) > currentServerTime)">
							<div class="actualTributes">{{0 | bidiRatio:village.data.tributeSum:village.data.tributesCapacity}}</div>
							<div progressbar
								class="populationBar"
								type="green"
								perc='{{village.data.tributePercentage}}'
								marker="{{village.data.tributeTreasureMarker}}"
								></div>
						</div>
						<div ng-if="getTributesOnTheirWay(village.data.villageId) > currentServerTime">
							<div class="actualTribes" data="inTime: {{getTributesOnTheirWay(village.data.villageId)}}" translate>Kingdom.Governors.TributeDeleveryIn</div>
						</div>
					</td>
					<td>
						<div ng-if="!(getTributesOnTheirWay(village.data.villageId) > currentServerTime) && village.data.tributeTreasures > 0">
							<i class="unit_treasure_small_illu " tooltip tooltip-translate="Resource.Treasures"></i>
							{{village.data.tributeTreasures}}
						</div>
					</td>
					<td class="tributeButtons">
						<span class="jsQuestTributeButtons villageType{{village.data.type}}">
							<button ng-show="!(getTributesOnTheirWay(village.data.villageId) > currentServerTime)"
									ng-class="{disabled: !village.data.canFetchTributes}"
									clickable="fetchTribute(village.data.villageId);"
									tooltip
									tooltip-url="tpl/society/partials/kingdom/tributesTooltip.html"
									play-on-click="{{UISound.BUTTON_COLLECT_TRIBUTES}}">
								<span translate>Tribute.FetchSelected</span>
							</button>
							<button ng-if="getTributesOnTheirWay(village.data.villageId) > currentServerTime"
									class="premium"
									premium-feature="{{instantFetchTributePremiumFeatureName}}"
									premium-callback-param="{{village.data.villageId}}">
								<span translate>Tribute.FetchInstant</span>
							</button>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/attackTooltip.html"><h3 translate data="count: {{attackedGovernors[village.data.playerId].villages[village.data.villageId].count}}">
	Kingdom.IncommingAttacks
</h3>
<div class="horizontalLine"></div>
<span translate data="nextAttack: {{attackedGovernors[village.data.playerId].villages[village.data.villageId].nextTimestamp}}">Kingdom.NextAttack</span></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/governorAttackTooltip.html"><h3 translate data="count: {{attackedGovernors[m.playerId].count}}">
	Kingdom.Information.GovernorAttackedVillagesCount
</h3>
<div class="horizontalLine"></div>
<div ng-repeat="attack in attackedGovernors[m.playerId].villages"
	 translate data="villageName: {{attack.villageName}}, nextAttack: {{attack.nextTimestamp}}">
		Kingdom.Information.GovernorAttackedVillage
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/influenceBarTooltip.html"><h3 data="level: {{village.level}}" translate>
	Kingdom.Territory.Village.Level
</h3>
<div class="horizontalLine"></div>
<span ng-show="village.populationForNextLevel >= 10000" translate>Kingdom.Territory.Village.MaxLevel</span>
<span ng-show="village.populationForNextLevel < 10000" data="needed: {{village.populationForNextLevel}}" translate>Kingdom.Territory.ToolTip.Village.NeededForNextLevel</span></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/influenceCalculationTooltip.html"><h3 translate>Kingdom.Territory.Influence</h3>
<div class="horizontalLine"></div>
<table class="transparent influenceTable">
	<tr>
		<th translate>Kingdom.Territory.Influence.Population</th>
		<td>{{village.population}}</td>
	</tr>
	<tr>
		<th data="value: {{village.treasureBonus}}" translate>Kingdom.Territory.Influence.TreasureBonus</th>
		<td>{{village.treasureBonusValue}}</td>
	</tr>
	<tr class="sumRow">
		<th translate>Kingdom.Territory.Influence.Total</th>
		<td>{{village.influence}}</td>
	</tr>
</table></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/influenceTooltip.html"><div class="influenceTooltip">
	<h3 translate data="cells:{{village.currentCells}}">
		Kingdom.Governors.TerritoryDistribution
	</h3>
	<div class="horizontalLine"></div>
	<div class="colorCube own"></div><span translate data="cells: {{village.cells.own}}">Kingdom.Governors.OwnCells</span>
	<div class="horizontalLine"></div>
	<div class="colorCube alliance"></div><span translate data="cells: {{village.cells.alliance}}">Kingdom.Governors.AllianceCells</span>
	<div class="horizontalLine"></div>
	<div class="colorCube other"></div><span translate data="cells: {{village.cells.other}}">Kingdom.Governors.OtherCells</span>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/inviteDuke.html"><div class="inviteDukePopup">
	<div class="contentBox transparent">
		<h6 class="contentBoxHeader headerColored" translate>
			Kingdom.Dukes.inviteDuke.governorName
		</h6>

		<div class="contentBoxBody">
			<serverautocomplete autocompletedata="player" autocompletecb="selectInvitePlayer" ng-model="invitePlayer" auto-focus-after-select=".inviteDukePopup .message"></serverautocomplete>
		</div>
	</div>
	<div class="contentBox transparent">
		<h6 class="contentBoxHeader headerColored" translate>
			Kingdom.Dukes.inviteDuke.messageToPlayer
		</h6>

		<div class="contentBoxBody">
			<textarea maxlength="{{societyInvitationMaxLength}}" class="message" ng-model="input.customText"></textarea>
		</div>
	</div>
	<div class="buttonFooter">
		<button clickable="invite();" ng-class="{'disabled':!selectedPlayer || selectedPlayer == null}">
			<span translate>Kingdom.Dukes.inviteDuke.Button.Accept</span>
		</button>
		<button clickable="closeOverlay();" class="cancel">
			<span translate>Button.Abort</span>
		</button>
		<div class="error">{{dukeInviteError}}</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/setTaxRate.html"><div class="setTaxRatePopup">
	<div class="headline" translate>Kingdom.Governors.SetTaxRate.Description</div>
	<div class="group">
		<div class="option taxRate">
			<label>
				<input type="radio" name="taxRate" ng-model="input.option" value="{{tax.LOW.rate}}">
				<span translate>Kingdom.Governors.TaxRate</span>: {{tax.LOW.rate | bidiNumber:'percent':false:false}}
			</label>
			<div class="body">
				<ul data="rateGovernor: {{tax.LOW.rateGovernor}}, rateTributes: {{tax.LOW.rate}}" translate>Kingdom.Governors.TaxRate.Advantages</ul>
			</div>
		</div>
		<div class="option taxRate">
			<label>
				<input type="radio" name="taxRate" ng-model="input.option" value="{{tax.MIDDLE.rate}}">
				<span translate>Kingdom.Governors.TaxRate</span>: {{tax.MIDDLE.rate | bidiNumber:'percent':false:false}}
			</label>
			<div class="body">
				<ul data="rateGovernor: {{tax.MIDDLE.rateGovernor}}, rateTributes: {{tax.MIDDLE.rate}}" translate>Kingdom.Governors.TaxRate.Advantages</ul>
			</div>
		</div>
		<div class="option taxRate">
			<label>
				<input type="radio" name="taxRate" ng-model="input.option" value="{{tax.HIGH.rate}}">
				<span translate>Kingdom.Governors.TaxRate</span>: {{tax.HIGH.rate | bidiNumber:'percent':false:false}}
			</label>
			<div class="body">
				<ul data="rateGovernor: {{tax.HIGH.rateGovernor}}, rateTributes: {{tax.HIGH.rate}}" translate>Kingdom.Governors.TaxRate.Advantages</ul>
			</div>
		</div>
	</div>
	<div class="additionalDescription">
		<div translate>Kingdom.Governors.SetTaxRate.LongDescription</div>
		<div class="caution"><i class="caution"></i> <span translate>Kingdom.Governors.SetTaxRate.Caution</span></div>
	</div>

	<div class="buttonFooter">
		<button clickable="setTaxRate();"><span translate>Kingdom.Governors.SetTaxRate.Button.Accept</span></button>
		<button clickable="closeOverlay();" class="cancel"><span translate>Button.Abort</span></button>
	</div>
	<div class="error">{{setTaxRateError}}</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/supportTooltip.html"><h3 translate>
	Kingdom.Governors.SupportTroops
</h3>
<div class="horizontalLine"></div>
{{supportedTroops[village.data.villageId].supply}} <i class="unit_consumption_small_flat_black" tooltip tooltip-translate="Resource.CropConsumption"></i></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/tributesProductionTooltip.html"><h3 translate>Kingdom.Governors.Tributes.ToolTip.ProductionHeadline</h3>
<div class="horizontalLine"></div>
<span data="production: {{village.data.tributeProduction}}" translate>Kingdom.Governors.Tributes.ToolTip.ProductionPerHour</span>
<div ng-if="!village.data.canFetchTributes">
	<span data="inTime: {{village.data.timeUntilTributeFetch}}" translate>Kingdom.Governors.Tributes.ToolTip.FetchableIn</span>
</div>
<div ng-if="village.data.canFetchTributes">
	<span data="inTime: {{village.data.timeUntilTributeFull}}" translate>Kingdom.Governors.Tributes.ToolTip.FullIn</span>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/tributesSumTooltip.html"><h3 translate>
	Tribute.FetchSelected
</h3>
<div class="horizontalLine"></div>
<span><i class="unit_treasure_small_flat_black" tooltip tooltip-translate="Resources"></i> {{village.tributeSum}}</span>
<span><i class="unit_treasure_small_flat_black" tooltip tooltip-translate="Tab.Treasures"></i> {{village.tributeTreasuresSum}}</span></script>
<script type="text/ng-template" id="tpl/society/partials/kingdom/tributesTooltip.html"><h3 translate>
	Tribute.FetchSelected
</h3>
<div class="horizontalLine"></div>
<div><i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="Duration"></i> {{tributeData[village.data.villageId].durationToKingVillage|HHMMSS}}</div>
<div class="horizontalLine"></div>
<display-resources resources="village.data.calculatedTributes"  treasures="village.data.tributeTreasures"></display-resources>
<div ng-show="tributeBonusPercent > 0">
	<br>
	<h3 translate>
		Tribute.StartBonus
	</h3>
	<div class="horizontalLine"></div>
	<display-resources resources="village.data.tributeBonus"></display-resources>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/secretSociety/editDescription.html"><div class="inWindowPopup secretSocietyEditDescription">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent" ng-controller=" secretSocietyEditDescriptionCtrl">
		<div class="inBox">
			<div class="contentBox transparent">
				<h6 class="contentBoxHeader headerColored" translate>Society.EditDescription.Description</h6>

				<div class="contentBoxBody">
					<textarea maxlength="2000" ng-model="description"></textarea>
				</div>
			</div>
		</div>
		<div class="buttonFooter">
			<button clickable="editDescription();">
				<span translate>Society.EditDescription.Button.Accept</span>
			</button>
			<button clickable="closeOverlay();" class="cancel">
				<span translate>Button.Abort</span>
			</button>
		</div>
		<div class="error">{{societyChangeDescriptionError}}</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/secretSociety/invite.html"><div class="inWindowPopup secretSocietyInvite">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent" ng-controller="secretSocietyInviteCtrl">
		<div class="inBox">
			<div class="contentBox transparent">
				<h6 class="contentBoxHeader headerColored" translate>Society.Invite.Name</h6>

				<div class="contentBoxBody">
					<div ng-repeat="(nr, player) in selectedPlayer track by $index">
						<serverautocomplete class="invitePlayer_{{nr}}" autocompletedata="player" ng-model="dummyModel" autocompletecb="selectInvitePlayer.{{nr}}" auto-focus-after-select=".secretSocietyInvite .invitePlayer_{{nr + 1}} input" input-autofocus="{{nr == selectedPlayer.length-1}}"></serverautocomplete>
						<span ng-if="nr == selectedPlayer.length-1 && nr < maxInvite-1">
							<div class="iconButton" clickable="addNewPlayer()" tooltip tooltip-translate="Group.Invite.AddAnotherPlayer">
								<i class="symbol_plus_tiny_flat_black"></i>
							</div>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="inBox">
			<div class="contentBox transparent">
				<h6 class="contentBoxHeader headerColored" translate>Society.Invite.OptionalMessage</h6>

				<div class="contentBoxBody">
					<textarea rows="10" maxlength="2000" ng-model="customText"></textarea>
				</div>
			</div>
		</div>

		<div class="buttonFooter">
			<button ng-class="{disabled: !atLeastOnePlayer}" clickable="inviteToSociety();">
				<span translate>Society.Invite.Button.Accept</span>
			</button>
			<button clickable="closeOverlay();" class="cancel">
				<span translate>Button.Abort</span>
			</button>
			<div class="error">{{societyInviteError}}</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/secretSociety/kick.html"><span translate data="playerId: {{player.data.playerId}}, playerName: {{player.data.name}}">Society.Kick.ConfirmationDescription</span>

<div class="buttonFooter">
	<button clickable="confirmKick();">
		<span translate>Society.Kick</span>
	</button>
	<button clickable="closeOverlay();" class="cancel">
		<span translate>Button.Cancel</span>
	</button>
</div></script>
<script type="text/ng-template" id="tpl/society/partials/secretSociety/openInvitations.html"><div class="inWindowPopup secretSocietyOpenInvitations">
	<div class="inWindowPopupHeader">
		<h4 translate options="{{overlayConfig['inWindowPopupTitle']}}">?</h4>
		<a class="closeOverlay" clickable="closeOverlay()" translate>Button.Close</a>
	</div>
	<div class="inWindowPopupContent openInvitations">
		<div pagination class="paginated"
					items-per-page="itemsPerPage"
					number-of-items="numberOfItems"
					current-page="currentPage"
					display-page-func="displayCurrentPage"
					route-named-param="cp2">
			<table>
				<tbody>
				<tr ng-repeat="invite in rows">
					<td class="nameColumn">
						<span player-link playerId="{{invite.data.playerId}}" playername="{{invite.data.playerName}}"></span>
					</td>
					<td class="invitationDate"><span i18ndt="{{invite.data.invitationTime}}" format="short"></span></td>
					<td class="close">
						<i ng-if="!isSitter" ng-class="{action_delete_small_flat_black: !deleteHover, action_delete_small_flat_red: deleteHover}"
						   clickable="revokeInvitation({{invite.data.id}});"
						   tooltip tooltip-translate="Group.RevokeInvitation"
						   on-pointer-over="deleteHover = true" on-pointer-out="deleteHover = false"></i>
					</td>
				</tr>
				<tr ng-if="invitations.data.length == 0">
					<td colspan="3" translate>Group.NoOpenInvitations</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="error">{{societyInviteRevokeError}}</div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/society/tabs/Alliance.html"><div ng-controller="ownAllianceCtrl" class="alliance">
    <div ng-if="alliance == null" class="notInAllianceDescription">
        <span ng-if="!user.data.isKing" translate>Error.NotInAllianceDescriptionGov</span>
        <span ng-if="user.data.isKing" translate>Error.NotInAllianceDescriptionKing</span>
    </div>
	<div ng-if="alliance != null">
		<div tabulation tab-config-name="allianceTabConfig">
			<div ng-include="tabBody_subtab"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/tabs/Attacks.html"><div ng-controller="attacksCtrl" class="incomingCommunityAttacks">
	<div scrollable height-dependency="max">
		<h6 class="headerWithIcon arrowDirectionDown">
			<i class="community_kingdom_medium_flat_black"></i>
			<div class="title"><span translate>Kingdom</span><span ng-show="total.kingdom>0"> | </span><span class="count warning" ng-show="total.kingdom>0"> &times; {{total.kingdom}}</span></div>
			<label><input type="checkbox" ng-model="show.kingdom" ng-change="update();"/><span translate>Attacks.ShowAttacks</span></label>
		</h6>
		<table ng-if="show.kingdom && total.kingdom>0">
			<thead>
				<tr>
					<th><span translate>Attacks.Player</span> / <span translate>Villages</span></th>
					<th></th>
					<th translate class="distance">TableHeader.Distance</th>
					<th translate class="arrival">Troops.Arrival</th>
				</tr>
			</thead>

			<tbody ng-repeat="player in showMembers.kingdom">
				<tr ng-show="player.playerId">
					<td colspan="4">
						<span player-link playerId="{{player.playerId}}" playerName="{{player.name}}"></span>
					</td>
				</tr>
				<tr ng-repeat="(villageId, village) in player.attacks.villages" ng-show="player.playerId">
					<td class="nameColumn">
						<span village-link villageId="{{villageId}}" villageName="{{village.villageName}}"></span>
					</td>
					<td><i class="movement_attack_small_flat_red"></i><span class="count"> &times; {{village.count}}</span></td>
					<td>
						{{village.distance | number:1}}
					</td>
					<td>
						<span class="countdown" countdown="{{village.nextTimestamp}}"></span>
						<span class="date" i18ndt="{{village.nextTimestamp}}" format="short"></span>
					</td>
				</tr>
			</tbody>
			<tr ng-show="showMembers.kingdom[0]">
				<td colspan="4">
					<span translate>Tab.Oases</span>
				</td>
			</tr>
			<tr ng-repeat="(villageId, village) in showMembers.kingdom[0].attacks.villages" ng-show="showMembers.kingdom[0]">
				<td class="nameColumn">
						<span class="coordinates">
							<span translate>Oasis</span>
							<div coordinates aligned="true" x="{{id2xy(villageId).x}}" y="{{id2xy(villageId).y}}"></div>
						</span>
				</td>
				<td><i class="movement_attack_small_flat_red"></i><span class="count"> &times; {{village.count}}</span></td>
				<td>
					{{village.distance | number:1}}
				</td>
				<td class="arrival">
					<span class="countdown" countdown="{{village.nextTimestamp}}"></span>
					<span class="date" i18ndt="{{village.nextTimestamp}}" format="short"></span>
				</td>
			</tr>
		</table>

		<h6 class="headerWithIcon arrowDirectionDown" ng-if="allianceId>0">
			<i class="community_alliance_medium_flat_black"></i>
			<div class="title"><span translate>Alliance</span><span ng-show="total.alliance>0"> | </span><span class="count" ng-show="total.alliance>0"> &times; {{total.alliance}}</span></div>
			<label><input type="checkbox" ng-model="show.alliance" ng-change="update();"/><span translate>Attacks.ShowAttacks</span></label>
		</h6>
		<table ng-if="show.alliance && allianceId>0 && total.alliance>0">
			<thead>
			<tr>
				<th><span translate>Attacks.Player</span> / <span translate>Villages</span></th>
				<th></th>
				<th class="distance" translate>TableHeader.Distance</th>
				<th class="arrival" translate>Troops.Arrival</th>
			</tr>
			</thead>

			<tbody ng-repeat="player in showMembers.alliance"  ng-show="player.playerId">
			<tr ng-show="player.playerId">
				<td colspan="4">
					<span player-link playerId="{{player.playerId}}" playerName="{{player.name}}"></span>
				</td>
			</tr>
			<tr ng-repeat="(villageId, village) in player.attacks.villages">
				<td class="nameColumn">
					<span village-link villageId="{{villageId}}" villageName="{{village.villageName}}"></span>
				</td>
				<td><i class="movement_attack_small_flat_red"></i><span class="count"> &times; {{village.count}}</span></td>
				<td>
					{{village.distance | number:1}}
				</td>
				<td class="arrival">
					<span class="countdown" countdown="{{village.nextTimestamp}}"></span>
					<span class="date" i18ndt="{{village.nextTimestamp}}" format="short"></span>
				</td>
			</tr>
			</tbody>
			<tr ng-show="showMembers.alliance[0]">
				<td colspan="4">
					<span translate>Tab.Oases</span>
				</td>
			</tr>
			<tr ng-repeat="(villageId, village) in showMembers.alliance[0].attacks.villages" ng-show="showMembers.alliance[0]">
				<td class="nameColumn">
						<span class="coordinates">
							<span translate>Oasis</span>
							<div coordinates aligned="true" x="{{id2xy(villageId).x}}" y="{{id2xy(villageId).y}}"></div>
						</span>
				</td>
				<td><i class="movement_attack_small_flat_red"></i><span class="count"> &times; {{village.count}}</span></td>
				<td>
					{{village.distance | number:1}}
				</td>
				<td class="arrival">
					<span class="countdown" countdown="{{village.nextTimestamp}}"></span>
					<span class="date" i18ndt="{{village.nextTimestamp}}" format="short"></span>
				</td>
			</tr>
		</table>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/tabs/Friends.html"><div ng-controller="friendsCtrl" class="friendList">
	<h6 class="headerWithIcon arrowDirectionDown">
		<i class="chat_friend_medium_flat_black"></i>
		<span translate>FriendList.Header</span>
	</h6>

	<div class="contentWrapper" scrollable height-dependency="max">
		<div class="category">
			<table class="addFriend">
				<thead>
					<tr>
						<th colspan="2" translate>
							FriendList.AddFriend.Header
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="searchFriend">
							<serverautocomplete class="autoCompleteFriend" autocompletedata="player" autocompletecb="changeNewFriend" ng-model="newFriend"></serverautocomplete>
						</td>
						<td class="sendRequest">
							<button clickable="sendAddRequest()">
								<span translate>FriendList.AddFriend.SendButton</span>
							</button>
						</td>
					</tr>
					<tr ng-if="addFriendError != ''">
						<td colspan="2" class="error">{{addFriendError}}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="category" ng-if="chat.friendRequests.data.length > 0">
			<table class="friendRequests">
				<thead>
					<tr>
						<th colspan="5" translate>FriendList.FriendRequests.Header</th>
					</tr>
				</thead>
				<tbody>
					<tr class="received" ng-repeat="chatUser in chat.friendRequests.data | orderBy:'data.timestamp':true" ng-if="chatUser.data.sourceId != currentPlayer.data.playerId">
						<td class="friendPicture">
							<chat-room-member player-id="{{chatUser.data.playerId}}" private-chat-mode="true"></chat-room-member>
						</td>
						<td class="friendLink">
							<span player-link playerId="{{chatUser.data.playerId}}" playerName="{{chatUser.data.name}}"></span>
						</td>
						<td class="requestStatus">
							<span translate>FriendList.FriendRequests.Received.Pending</span>
						</td>
						<td class="acceptButton">
							<button clickable="acceptFriend(chatUser.data.playerId, chatUser.data.timestamp)" tooltip tooltip-translate="FriendList.FriendRequests.Received.Accept.Tooltip">
								<span translate>FriendList.FriendRequests.Received.Accept</span>
							</button>
						</td>
						<td class="cancelButton">
							<button class="cancel" clickable="declineFriend(chatUser.data.playerId, chatUser.data.timestamp)" tooltip tooltip-translate="FriendList.FriendRequests.Received.Decline.Tooltip">
								<span translate>FriendList.FriendRequests.Received.Decline</span>
							</button>
						</td>
					</tr>
					<tr class="sent" ng-repeat="chatUser in chat.friendRequests.data | orderBy:'data.timestamp':true" ng-if="chatUser.data.sourceId == currentPlayer.data.playerId">
						<td class="friendPicture">
							<chat-room-member player-id="{{chatUser.data.playerId}}" private-chat-mode="true"></chat-room-member>
						</td>
						<td class="friendLink">
							<span player-link playerId="{{chatUser.data.playerId}}" playerName="{{chatUser.data.name}}"></span>
						</td>
						<td colspan="2" class="requestStatus">
							<span translate data="timestamp: {{chatUser.data.timestamp}}">FriendList.FriendRequests.Sent.InvitationSent</span>
						</td>
						<td class="cancelButton">
							<button class="cancel" clickable="cancelFriendRequest(chatUser.data.playerId, chatUser.data.timestamp)" tooltip tooltip-translate="FriendList.FriendRequests.Sent.Cancel.Tooltip">
								<span translate>Button.Cancel</span>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="category" ng-if="chat.friendList.data.length > 0">
			<table class="friends">
				<thead>
					<tr>
						<th colspan="3" translate>FriendList.Friends.Header</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="friend in chat.friendList.data">
						<td class="friendPicture">
							<chat-room-member player-id="{{friend.data.playerId}}" private-chat-mode="true"></chat-room-member>
						</td>
						<td>
							<span player-link playerId="{{friend.data.playerId}}" playerName="{{friend.data.name}}"></span>
						</td>
						<td class="deleteFriend">
							<i ng-class="{action_cancel_small_flat_black: !cancelHover, action_cancel_small_flat_red: cancelHover}"
							   on-pointer-over="cancelHover = true" on-pointer-out="cancelHover = false"
							   tooltip tooltip-translate="FriendList.Friends.RemoveTooltip"
							   clickable="deleteFriend(friend.data.playerId)"></i>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/society/tabs/Kingdom.html"><div class="kingdom" ng-controller="kingdomCtrl">
	<div tabulation tab-config-name="kingdomTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>
	<div class="error">{{kingError}}</div>
</div></script>
<script type="text/ng-template" id="tpl/society/tabs/SecretSociety.html"><div ng-controller="secretSocietyDetailCtrl" class="secretSociety defaultWindow">
	<div ng-if="noSociety" translate>Society.NoSociety</div>
	<div ng-show="!noSociety" class="dynamicTabulationContainer">
		<dynamic-tabulation watch-var="societies.data" collection-key="data.groupId" active-tab="{{societyId}}" class="tabulation subtab subtab dynamicTabulation">
			<div class="tabWrapper">
				<a class="tab" ng-repeat="tabSociety in tabs"
				   ng-class="{active: societyId == tabSociety.data.groupId, inactive: societyId != tabSociety.data.groupId}"
				   clickable="selectSociety(tabSociety.data.groupId);">
					<div class="content">
						<span>{{tabSociety.data.name}}</span>
					</div>
				</a>
				<a class="tab showHidden" clickable="toggleDropdown()" ng-show="tabsMore.length > 0">
					<div class="iconButton">
						<i class="symbol_arrowDown_tiny_illu"></i>
						<span class="moreTabsAmount">{{tabsMore.length}}</span>
						<div class="dropdownBody dynamicTabulationDropdown" ng-show="showHiddenTabsDropdown">
							<ul>
								<li ng-repeat="tabSociety in tabsMore" clickable="selectSociety(tabSociety.data.groupId);">
									<span>
										{{tabSociety.data.name}}
									</span>
								</li>
							</ul>
						</div>
					</div>
				</a>
			</div>
		</dynamic-tabulation>

		<h6 class="headerWithIcon arrowDirectionDown" ng-class="{openInvitations: invitations.data.length > 0}">
			<i class="community_secretSociety_medium_flat_black"></i>
			{{society.data.name}}
			<a ng-if="isFounder"
			   class="invitations"
			   clickable="openOverlay('secretSocietyOpenInvitations', {'groupId': {{society.data.groupId}} });"
			   ng-class="{disabled: invitations.data.length <= 0}">
				<span translate data="cnt: {{invitations.data.length}}">Group.OpenInvitations</span>
				<i class="community_invitation_small_illu" ng-class="{disabled: invitations.data.length <= 0}"></i>
			</a>
		</h6>

		<div class="contentBox gradient">
			<h6 class="contentBoxHeader headerWithArrowEndings glorious">
				<div class="content">
					<span translate>Society.Founder</span>
					<span player-link playerId="{{founder.playerId}}" playerName="{{founder.name}}"></span>

				</div>
				<i class="headerButton"
				   ng-class="{action_edit_small_flat_black: !editHover, action_edit_small_flat_green: editHover}"
				   on-pointer-over="editHover = true" on-pointer-out="editHover = false"
				   ng-if="isFounder && !isSitter"
				   tooltip tooltip-translate="Society.EditDescription.Headline"
				   clickable="openOverlay('secretSocietyEditDescription', {'groupId': {{society.data.groupId}} });"></i>
			</h6>
			<div class="contentBoxBody">
				<div class="column target">
					<i class="secretSocietyLogo"
					   ng-class="{secretSociety_bright_huge_illu: society.data.attitude == 1, secretSociety_dark_huge_illu: society.data.attitude == 2}"></i>
					<div class="targetContainer">
						<div ng-if="society.data.targetType == target.village">
							<span translate options="{{attitudeName[society.data.attitude]}}">Society.Target.?.Village</span>
							<span village-link villageid="{{targetObj.data.villageId}}" villagename="{{targetObj.data.name}}"></span>
						</div>
						<div ng-if="society.data.targetType == target.player">
							<span translate options="{{attitudeName[society.data.attitude]}}">Society.Target.?.Player</span>
							<span player-link playerId="{{targetObj.data.playerId}}" playerName="{{targetObj.data.name}}"></span>
						</div>
						<div ng-if="society.data.targetType == target.kingdom">
							<span translate options="{{attitudeName[society.data.attitude]}}">Society.Target.?.Kingdom</span>
							<span player-link playerId="{{targetObj.data.playerId}}" playerName="{{targetObj.data.name}}"></span>
						</div>
						<div ng-if="society.data.targetType == target.alliance">
							<span translate options="{{attitudeName[society.data.attitude]}}">Society.Target.?.Alliance</span>
							<alliance-link allianceId="{{targetObj.data.id}}" allianceName="{{targetObj.data.name}}"></alliance-link>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="header">
						<span translate>Society.Description</span>
					</div>
					<div class="text" scrollable>
						{{society.data.profile.description}}
					</div>
				</div>
			</div>
		</div>

		<div pagination class="paginated"
					items-per-page="itemsPerPage"
					number-of-items="numberOfItems"
					current-page="currentPage"
					display-page-func="displayCurrentPage"
					route-named-param="cp">
			<table class="memberList">
				<thead>
					<tr>
						<th class="name" colspan="2" translate>Society.Members</th>
						<th><i class="village_village_small_flat_black" tooltip tooltip-translate="Villages"></i></th>
						<th><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i></th>
						<th><i ng-class="{
									movement_trade_small_flat_black: society.data.attitude == 1,
									unit_capacity_small_flat_black: society.data.attitude == 2
								}"
							   tooltip tooltip-translate="Society.Stats.Resources{{society.data.attitude}}"></i>
						</th>
						<th><i ng-class="{
									secretSociety_troopsLost_small_flat_black: society.data.attitude == 1,
									secretSociety_troopsDefeated_small_flat_black: society.data.attitude == 2
								}"
							   tooltip tooltip-translate="Society.Stats.Troops{{society.data.attitude}}"></i></th>
						<th>
							<i ng-if="society.data.attitude == 1" class="secretSociety_troopsProvided_small_flat_black" tooltip tooltip-translate="Society.Stats.TroopsDeployed"></i>
							<i ng-if="society.data.attitude == 2" class="unit_treasure_small_flat_black" tooltip tooltip-translate="Society.Stats.Treasures"></i>
						</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
				<tr ng-repeat="member in rows" on-pointer-over="member.showOptions = true" on-pointer-out="member.showOptions = false">
					<td class="orderNr">{{ (currentPage-1)*itemsPerPage + $index + 1 }}.</td>
					<td class="name">
						<i ng-if="member.isFounder" class="secretSociety_leader_small_flat_black" tooltip tooltip-translate="Communities.SecretSociety.Leader"></i>
						<i ng-if="!member.isFounder" class="secretSociety_member_small_flat_black" tooltip tooltip-translate="Communities.SecretSociety.Member"></i>
						<span player-link playerId="{{member.playerId}}" playerName="{{member.name}}"></span>
					</td>
					<td>{{member.villages}}</td>
						<td>{{member.population}}</td>
						<td>
							<span ng-if="society.data.attitude == 1">{{stats[member.playerId].resourcesSent|number:0}}</span>
							<span ng-if="society.data.attitude == 2">{{stats[member.playerId].resourcesStolen|number:0}}</span>
						</td>
						<td>
							<span ng-if="society.data.attitude == 1">{{stats[member.playerId].troopsLost|number:0}}</span>
							<span ng-if="society.data.attitude == 2">{{stats[member.playerId].troopsKilled|number:0}}</span>
						</td>
						<td>
							<span ng-if="society.data.attitude == 1">{{stats[member.playerId].troopsDeployed}}</span>
							<span ng-if="society.data.attitude == 2">{{stats[member.playerId].treasuresStolen}}</span>
						</td>
					<td class="options">
						<i ng-show="member.showOptions && isFounder && user.data.playerId != member.playerId"
						   ng-class="{action_leave_small_flat_black: !leaveHover, action_leave_small_flat_red: leaveHover}"
						   on-pointer-over="leaveHover = true" on-pointer-out="leaveHover = false"
						   clickable="openOverlay('secretSocietyKick', {'playerId': {{member.playerId}}, 'societyId': {{society.data.groupId}} });"
						   tooltip tooltip-translate="Society.Kick"></i>
					</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="buttonFooter">
			<div ng-if="isFounder">
				<button ng-if="!isSitter"
						clickable="openOverlay('secretSocietyInvite', {'groupId': {{society.data.groupId}} });">
					<span translate>Group.Button.Invite</span>
				</button>
				<button class="disabled"
						tooltip
						tooltip-translate="Sitter.DisabledAsSitter"
						ng-if="isSitter">
					<span translate>Group.Button.Invite</span>
				</button>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/startVillage/startVillage.html"><div ng-controller="startVillageCtrl">
	<div ng-if="player.data.tribeId > 0">
		<div ng-include src="'tpl/startVillage/partials/selectVillage.html'"></div>
	</div>
	<div ng-if="player.data.tribeId <= 0">
		<div ng-include src="'tpl/startVillage/partials/selectTribe.html'"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/startVillage/partials/selectTribe.html"><h2 translate>Player.SelectTribeTitle</h2>
<div class="startTribeSelection">
	<p translate>Player.TribeSelection</p>

	<div class="tribeContainer">
		<div class="tribe tribe{{t}}" ng-repeat="t in [3,1,2]" ng-class="{selected: input.tribe == t}" clickable="input.tribe={{t}}">
		</div>
	</div>

	<div class="tribeDescription">
		<div class="arrowToTribe tribe{{input.tribe}}"></div>
		<h4 translate options="{{input.tribe}}">Tribe_?</h4>
	</div>
	<div>
		<button clickable="selectTribe()"><span translate>Player.SelectTribe</span></button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/startVillage/partials/selectVillage.html"><h2 translate>Map.SelectDirectionTitle</h2>
<button clickable="backToTribe()"><span translate>Player.BackToSelectTribe</span></button>

<p translate>Map.DirectionSelection</p>

<div class="sectorSelectMap">
	<div class="highlight sector{{dir}}" ng-repeat="dir in [1,2,3,4]" ng-class="{selected: input.direction == dir}" clickable="input.direction={{dir}}">
	</div>
</div>

<div class="sectorSelectOptions">
	<label ng-repeat="dir in [0,1,2,3,4]">
		<input type="radio" name="sector" value="{{dir}}" ng-model="input.direction" />
		<span translate options="{{dir}}">Map.Direction_?</span>
	</label>

	<button clickable="confirmSelection()">
		<span translate>Map.CreateVillage</span>
	</button>
</div>
</script>
<script type="text/ng-template" id="tpl/statistics/statistics.html"><div class="statistics" ng-controller="statsCtrl">
    <div ng-include="tabBody_tab"></div>

	<div ng-show="showSearch()" class="rankingSearch">
		<span translate>Rank</span>
		<input type="text" class="rank" ng-model="search.rank" ng-change="filterInputSearchRank()" auto-focus/>
		<span translate>Statistics.OrName</span>
		<serverautocomplete class="name" vertical-align="above" autocompletedata="{{search.autocompleteParam}}" autocompletecb="setSearchName" ng-model="search.name"></serverautocomplete>
		<button clickable="searchItem()">
			<span translate>Button.Ok</span>
		</button>
	</div>
	<span class="error">{{rankError}}</span>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsAlliances.html"><div ng-controller="statsAlliancesCtrl">

	<div tabulation tab-config-name="statsAlliancesTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>

</div>
</script>
<script type="text/ng-template" id="tpl/statistics/statsAlliancesArea.html"><div>
	<h4 translate>Statistics.Alliance.Size.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Players</th>
				<th translate>TableHeader.Average</th>
				<th translate>TableHeader.Fields</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.allianceId == player.data.allianceId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.tag}}"></alliance-link></td>
				<td>{{result.membersCount}}</td>
				<td>{{result.points/result.membersCount | number: 0}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsAlliancesAttacker.html"><div>
	<h4 translate>Statistics.Alliance.Attacker.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Players</th>
				<th translate>TableHeader.Average</th>
				<th translate>TableHeader.Points</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.allianceId == player.data.allianceId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.tag}}"></alliance-link></td>
				<td>{{result.membersCount}}</td>
				<td>{{result.points/result.membersCount | number: 0}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsAlliancesDefender.html"><div>
	<h4 translate>Statistics.Alliance.Defender.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Players</th>
				<th translate>TableHeader.Average</th>
				<th translate>TableHeader.Points</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.allianceId == player.data.allianceId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.tag}}"></alliance-link></td>
				<td>{{result.membersCount}}</td>
				<td>{{result.points/result.membersCount | number: 0}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsAlliancesPopulation.html"><div>
	<h4 translate>Statistics.Alliance.Overview.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Players</th>
				<th translate>TableHeader.Average</th>
				<th translate>TableHeader.Points</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.allianceId == player.data.allianceId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.tag}}"></alliance-link></td>
				<td>{{result.membersCount}}</td>
				<td>{{result.points/result.membersCount | number: 0}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsAlliancesTop10.html"><div class="top10Ranking">
	<div ng-controller="statsAllianceTop10Ctrl">
		<div class="top10quarter" ng-repeat="top10 in top10Lists">
			<h4>{{top10.title}}</h4>
			<table>
				<thead>
				<tr>
					<th class="currNo" translate>TableHeader.Counter</th>
					<th class="player" translate>TableHeader.Alliance</th>
					<th class="points">{{top10.pointsTitle}}</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="result in top10.data">
					<td class="currNo">{{result.rank|rank}}.</td>
					<td class="player">
						<alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.tag}}"></alliance-link>
					</td>
					<td class="points">{{result.points}}</td>
				</tr>
				<!-- show own data -->
				<tr class="highlighted">
					<td class="currNo" ng-show="top10.ownData[0].rank == '?'">?</td>
					<td class="currNo" ng-hide="top10.ownData[0].rank == '?'">{{top10.ownData[0].rank|rank}}.</td>

					<td class="player">
						<alliance-link allianceId="{{top10.ownData[0].allianceId}}"
									   allianceName="{{top10.ownData[0].tag}}"></alliance-link>
					</td>
					<td class="points">{{top10.ownData[0].points}}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsAlliancesVictoryPoints.html"><div>
	<h4 translate>Statistics.Alliance.VictoryPoints.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Players</th>
				<th translate>TableHeader.Average</th>
				<th translate>TableHeader.Points</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.allianceId == player.data.allianceId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.tag}}"></alliance-link></td>
				<td>{{result.membersCount}}</td>
				<td>{{result.points/result.membersCount | number: 0}}</td>
				<td ng-if="result.bonus" tooltip tooltip-translate="Statistics.Alliance.VictoryPoints.Total" tooltip-data="totalPoints: {{(1+result.bonus)*result.points | number: 0}}" tooltip-placement="above">{{result.points | number: 0}} <span class="pointsBonus">{{result.bonus * 100 | bidiNumber:'percent':true:false:false}}</span></td>
				<td ng-if="!result.bonus">{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsKingdoms.html"><div ng-controller="statsKingdomsCtrl">

	<div tabulation tab-config-name="statsKingdomTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>

</div></script>
<script type="text/ng-template" id="tpl/statistics/statsKingdomsPopulation.html"><div>
	<h4 translate>Statistics.Kingdoms.Population.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Villages</th>
				<th translate>TableHeader.Population</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td class="nameColumn">
				<span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span>
				</td>
				<td>
					<alliance-link allianceId="{{result.allianceId}}"
								   allianceName="{{result.allianceTag}}"></alliance-link>
				</td>
				<td>{{result.village}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsKingdomsSize.html"><div>
	<h4 translate>Statistics.Kingdoms.Size.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Villages</th>
				<th translate>TableHeader.Size</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td>
					<span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span>
				</td>
				<td>
					<alliance-link allianceId="{{result.allianceId}}"
								   allianceName="{{result.allianceTag}}"></alliance-link>
				</td>
				<td>{{result.village}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsKingdomsTreasures.html"><div>
	<h4 translate>Statistics.Kingdoms.Treasures.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Villages</th>
				<th translate>TableHeader.Treasures</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td>
					<span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span>
				</td>
				<td>
					<alliance-link allianceId="{{result.allianceId}}"
								   allianceName="{{result.allianceTag}}"></alliance-link>
				</td>
				<td>{{result.village}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayer.html"><div ng-controller="statsPlayerCtrl">

	<div tabulation tab-config-name="statsPlayerTabConfig">

		<div ng-include="tabBody_subtab"></div>

	</div>

</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayerAttacker.html"><div>
	<h4 translate>Statistics.Player.Attacker.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Population</th>
				<th translate>TableHeader.Villages</th>
				<th translate>TableHeader.Points</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span></td>
				<td>{{result.population}}</td>
				<td>{{result.village}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayerDefender.html"><div>
	<h4 translate>Statistics.Player.Defender.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Population</th>
				<th translate>TableHeader.Villages</th>
				<th translate>TableHeader.Points</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span></td>
				<td>{{result.population}}</td>
				<td>{{result.village}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayerHeroes.html"><div>
	<h4 translate>Statistics.Player.Heroes.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Level</th>
				<th translate>TableHeader.Experience</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td><span player-link playerId="{{result.playerId}}" playerName="{{result.playerName}}"></span></td>
				<td>{{result.level | number: 0}}</td>
				<td>{{result.points | number: 0}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayerOverview.html"><div>
	<h4 translate>Statistics.Player.Overview.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table>
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Population</th>
				<th translate>TableHeader.Villages</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td class="nameColumn">
				<span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span>
				</td>
				<td>
					<alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.allianceTag}}"></alliance-link>
				<td>{{result.points | number: 0}}</td>
				<td>{{result.village}}</td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayerTop10.html"><div class="top10Ranking">
	<div ng-controller="statsPlayerTop10Ctrl">
		<div class="top10quarter" ng-repeat="top10 in top10Lists">
			<h4>{{top10.title}}</h4>
			<table>
				<thead>
				<tr>
					<th class="currNo" translate>TableHeader.Counter</th>
					<th class="player" translate>TableHeader.Player</th>
					<th class="points">{{top10.pointsTitle}}</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="result in top10.data" ng-class="{highlighted: result.playerId == player.data.playerId}">
					<td class="currNo">{{result.rank|rank}}.</td>
					<td class="player">
						<div class="longTitle"><span player-link playerId="{{result.playerId}}" playerName="{{result.name}}"></span></div>
					</td>
					<td class="points"><div>{{result.points}}</div></td>
				</tr>
				<!-- show own stat -->
				<tr class="highlighted">
					<td class="currNo" ng-show="top10.ownData[0].rank == '?'">?</td>
					<td class="currNo" ng-hide="top10.ownData[0].rank == '?'">{{top10.ownData[0].rank|rank}}.</td>
					<td class="player">
						<div class="longTitle"><span player-link playerId="{{top10.ownData[0].playerId}}" playerName="{{top10.ownData[0].name}}"></span></div>
					</td>
					<td class="points">{{top10.ownData[0].points}}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsPlayerVillages.html"><div>
	<h4 translate>Statistics.Player.Villages.Title</h4>

	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table class="playerVillages">
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Village</th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Pop</th>
				<th class="coordinates"><i class="symbol_target_small_flat_black"></i></th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{result.rank|rank}}.</td>
				<td class="nameColumn">
					<span village-link villageId="{{result.villageId}}" villageName="{{result.name}}"></span>
				</td>
				<td class="nameColumn">
					<span player-link playerId="{{result.playerId}}" playerName="{{result.playerName}}"></span>
				</td>
				<td>{{result.points | number: 0}}</td>
				<td class="coordinates"><div coordinates aligned="true" x="{{result.coordinates.x}}" y="{{result.coordinates.y}}"></div></td>
			</tr>
			</tbody>
		</table>

	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsWorld.html"><div ng-controller="statsWorldCtrl" class="statsWorld">
	<div scrollable>
		<div class="contentBox gradient">
			<div class="contentBoxHeader headerWithArrowEndings">
				<span translate class="content">Statistics.World.Players.Title</span>
			</div>
			<div class="contentBoxBody">
				<table class="worldStatsTable transparent">
					<tr>
						<th translate>Statistics.World.Players.Registered</th>
						<td>{{stats.players.registered}}</td>
					</tr>
					<tr>
						<th translate>Statistics.World.Players.Active</th>
						<td>{{stats.players.active}}</td>
					</tr>
					<tr>
						<th translate>Statistics.World.Players.Online</th>
						<td>{{stats.players.online}}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="contentBox gradient pieCharts">
			<div class="contentBoxHeader headerWithArrowEndings glorious">
				<div class="content">
					<span translate>Statistics.World.Kingdom.Title</span>
				</div>
			</div>
			<div class="contentBoxHeader headerWithArrowEndings">
				<div class="content">
					<span translate>Statistics.World.Tribes.Title</span>
				</div>
			</div>
			<div class="contentBoxBody">
				<pie-chart class="pieChart kingdomChart" data="kingdomPieData" percent-in-pie="true"></pie-chart>
				<pie-chart class="pieChart tribeChart" data="tribePieData" percent-in-pie="true"></pie-chart>
			</div>
		</div>
		<div class="contentBox gradient">
			<div class="contentBoxHeader headerWithArrowEndings">
				<span translate class="content">Statistics.World.GameWorld.Title</span>
			</div>
			<div class="contentBoxBody">
				<table class="worldStatsTable transparent">
					<tr>
						<th translate>Statistics.World.GameWorld.Start</th>
						<td><span i18ndt="{{stats.world.startTime}}"></span></td>
					</tr>
					<tr>
						<th translate>Statistics.World.GameWorld.Age</th>
						<td>{{(currentServerTime - stats.world.startTime)/86400 | number:0}}</td>
					</tr>
					<tr>
						<th translate>Statistics.World.GameWorld.Speed</th>
						<td>{{stats.world.speed}}</td>
					</tr>
					<tr>
						<th translate>Statistics.World.GameWorld.TroopSpeed</th>
						<td>{{stats.world.speedTroops}}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="contentBox gradient">
			<div class="contentBoxHeader headerWithArrowEndings">
				<span translate class="content">Statistics.World.Troops.Title</span>
			</div>
			<div class="contentBoxBody">
				<div ng-repeat="(tribeId, troopDetails) in troops" class="worldTroops">
					<div class="tribeCaption">
						<span><span translate options="{{tribeId}}">Tribe_?</span>:</span>
					</div>
					<div troops-details troop-data="troopDetails"></div>
				</div>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/statistics/statsWorldWonder.html"><div ng-controller="statsWorldWonderCtrl">
	<div pagination items-per-page="itemsPerPage"
				number-of-items="numberOfItems"
				current-page="currentPage"
				display-page-func="displayCurrentPage"
				route-named-param="statsPage">

		<table class="worldWonder">
			<thead>
			<tr>
				<th></th>
				<th translate>TableHeader.Player</th>
				<th translate>TableHeader.Name</th>
				<th translate>TableHeader.Alliance</th>
				<th translate>TableHeader.Level</th>
				<th translate>TableHeader.Bonus</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="result in rankings track by $index" ng-class="{highlighted: result.playerId == player.data.playerId || result.rank == searchedRank}">
				<td>{{$index+1}}.</td>
				<td class="nameColumn"><span player-link playerId="{{result.playerId}}" playerName="{{result.playerName}}" class="truncated"></span></td>
				<td class="nameColumn"><div class="truncated">{{result.name}}</div></td>
				<td class="nameColumn"><alliance-link allianceId="{{result.allianceId}}" allianceName="{{result.allianceTag}}"></alliance-link></td>
				<td>{{result.level}}</td>
				<td>{{result.bonus*100 | bidiNumber:'percent':true:false:null:null:0}}</td>
			</tr>
			</tbody>
		</table>

	</div>

</div></script>
<script type="text/ng-template" id="tpl/systemMessage/header.html"><div class="contentHeader">
	 <h2>{{w.windowName}}</h2>
</div></script>
<script type="text/ng-template" id="tpl/systemMessage/systemMessage.html"><div ng-controller="systemMessageCtrl">
	<div ng-bind-html="systemMessage"></div>
</div></script>
<script type="text/ng-template" id="tpl/tooltip/tooltipTranslate.html"><span translate options="{{tOptions}}">?</span></script>
<script type="text/ng-template" id="tpl/troopDetails/partials/troopTable.html"><table class="troopsTable {{tribeNames[troopData.tribeId]}}">
	<tbody class="troopsIconRow">
		<tr>
			<td ng-repeat="n in []|range:1:11" class="{{n == Troops.TYPE_HERO ? 'hero' : 'unit'+n}}">
				<span unit-icon data="{{getTroopId(troopData.tribeId, n)}}" ng-init="group=troopData; unitId=n"
						   clickable="{{unitIconCallback ? 'unitIconCallback(troopData, n)' : ''}}"
						   ng-class="{inactive: (troopData['originalTroops'] && !troopData['originalTroops'][n])
								   				|| (!troopData['originalTroops'] && (!troopData['inputTroops'][n] || troopData['inputTroops'][n] <= 0)),
								   	  clickable: unitIconCallback}"
						   tooltip tooltip-placement="above"
						   tooltip-url="tpl/mainlayout/partials/troopTypeTooltip.html"></span>
				<div class="unitBonusContainer" ng-if="troopData.unitBonuses[n+(troopData.tribeId-1)*10]"
					 tooltip tooltip-translate="Hero.ItemBonus_11" tooltip-child-class="increaseArrow"
					 tooltip-data="x:{{troopData.unitBonuses[n+(troopData.tribeId-1)*10].bonus}},name:{{troopData.unitBonuses[n+(troopData.tribeId-1)*10].unitName}}">
					<i class="increaseArrow symbol_increaseArrow_tiny_flat_white"></i>
				 </div>
				<div class="horizontalLine" ng-if="troopData['originalTroops'] || !troopData['inputTroops']"></div>
			</td>
		</tr>
	</tbody>
	<tbody ng-if="troopData[troopsType+'Troops']" class="{{troopsType}}Troops" ng-repeat="troopsType in ['original', 'input', 'lost', 'trapped']">
		<tr ng-if="troopsType == 'trapped'" class="subHeader">
			<td colspan="11">
				<span><span translate>Troops.Trapped</span>:</span>
			</td>
		</tr>
		<tr>
			<td ng-repeat="n in [] | range:1:11" class="{{n == Troops.TYPE_HERO ? 'hero' : 'unit'+n}}">
				<span ng-if="troopsType == 'original' && (!troopData[troopsType+'Troops'][n] || troopData[troopsType+'Troops'][n] == 0)">-</span>
				<span ng-if="troopsType == 'original' && troopData[troopsType+'Troops'][n] < 0">?</span>

				<div ng-if="troopsType != 'input' && troopData[troopsType+'Troops'][n] >= 1">
					<a ng-if="troopsType == 'original' && troopData['inputTroops']" clickable="addUnit(n);"
						>{{troopData[troopsType+'Troops'][n] | shortBigNumber:99999:0}}</a>
					<span ng-if="(troopsType != 'original' || !troopData['inputTroops']) && !(troopsType == 'lost' && n == Troops.TYPE_HERO && troopData['heroHealthLoss'])"
						>{{troopData[troopsType+'Troops'][n] | bidiNumber:"":false:false:99999:0}}</span>
					<span ng-if="troopsType == 'lost' && n == Troops.TYPE_HERO && troopData['heroHealthLoss']"
						>{{troopData['heroHealthLoss'] | bidiNumber:"percent"}}</span>
				</div>
				<input ng-if="troopsType == 'input'" number="{{troopData.originalTroops[n]}}" ng-model="troopData.inputTroops[n]" hide-zero="true"
					   hide-negative="true" ng-disabled="troopData.inputTroops[n] < 0" class="unitInput{{n-1}}"
					   tooltip tooltip-translate="CombatSimulator.troopAmount"/>
			</td>
		</tr>
	</tbody>
	<tbody ng-if="troopData.supply">
		<tr class="subHeader">
			<td colspan="11">
				<span><span translate>Troops.Upkeep</span>:</span>
			</td>
		</tr>
		<tr>
			<td colspan="11" class="upkeep">
				<i class="unit_consumption_small_flat_black"></i> {{troopData.supply}} <span translate>perHour</span>
			</td>
		</tr>
	</tbody>
	<tbody ng-if="troopData.cagedAnimals">
		<tr class="subHeader">
			<td colspan="11">
				<span><span translate data="amount:{{troopData.cagedAnimals}}">Report.UsedCages</span></span>
			</td>
		</tr>
	</tbody>
</table></script>
<script type="text/ng-template" id="tpl/troopDetails/rallypoint/troopDetailsRallypoint.html"><div class="troopsDetailContainer">
	<div class="troopsDetailHeader" ng-if="!showInputFields">
		<div class="troopsTitle centered" ng-if="status == 'send'">
			<span translate>RallyPoint.Troops.YourTroops</span>
		</div>
		<div class="troopsTitle" ng-if="isGroup">
			<span translate data="tribe: {{troopDetails.tribeName}}, amount:{{troopDetails.troopsGroup.length}}">RallyPoint.TroopGroup</span>
				<span ng-if="status == 'homeTrap'">
					<span translate>RallyPoint.TroopGroup.TrappedAddon</span>
				</span>
		</div>
		<div class="troopsTitle" ng-if="status != 'send' && !isGroup">
			<div ng-if="status == 'home' && troopDetails.tribeId != tribes.NATURE">
				<span translate data="villageId: {{troopDetails.villageId}}, villageName: {{troopDetails.villageName}}">RallyPoint.Troops.OwnTroops</span>
			</div>
			<div ng-if="status == 'nature'">
				<span translate>RallyPoint.Troops.Nature</span>
			</div>
			<div ng-if="status == 'support'">
				<span translate data="villageId: {{troopDetails.villageId}}, villageName: {{troopDetails.villageName}},
									 playerId: {{troopDetails.playerId}}, playerName: {{troopDetails.playerName}}">RallyPoint.Troops.Supporter
				</span>
			</div>
			<div ng-if="status == 'oasisSupport'">
				<span translate data="villageId: {{troopDetails.villageId}}, villageName: {{troopDetails.villageName}},
									 playerId: {{troopDetails.playerId}}, playerName: {{troopDetails.playerName}},
									 oasisId: {{troopDetails.villageIdLocation}}, oasisName: {{troopDetails.villageNameLocation}}">RallyPoint.Troops.Oasis.Supporter
				</span>
			</div>
			<div ng-if="status == 'ownSupport'">
				<span translate data="villageId: {{troopDetails.villageId}}, villageName: {{troopDetails.villageName}},
									 playerId: {{troopDetails.playerId}}, playerName: {{troopDetails.playerName}}">RallyPoint.Troops.Supporter
				</span>
			</div>
			<div ng-if="status == 'awaySupport'">
				<span translate data="villageId: {{troopDetails.villageIdLocation}}, villageName: {{troopDetails.villageNameLocation}},
									 playerId: {{troopDetails.playerIdLocation}}, playerName: {{troopDetails.playerNameLocation}}">RallyPoint.Troops.Away_support
				</span>
			</div>
			<div ng-if="status == 'homeTrap'">
				<span translate data="villageId: {{troopDetails.villageId}}, villageName: {{troopDetails.villageName}},
									 playerId: {{troopDetails.playerId}}, playerName: {{troopDetails.playerName}}">RallyPoint.Troops.Home_trap
				</span>
			</div>
			<div ng-if="status == 'awayTrap'">
				<span translate data="villageId: {{troopDetails.villageIdLocation}}, villageName: {{troopDetails.villageNameLocation}},
									 playerId: {{troopDetails.playerIdLocation}}, playerName: {{troopDetails.playerNameLocation}}">RallyPoint.Troops.Away_trap
				</span>
			</div>
			<div ng-if="status == 'incoming'">
				<i class="movement incoming {{movementIcon}}" tooltip tooltip-translate="TroopMovementInfo_{{movementGroup}}" tooltip-placement="above"></i>
				<span ng-if="!oasis">
					<span translate ng-if="troopDetails.movement.movementType == Troops.MOVEMENT_TYPE_TRIBUTE_COLLECT"
							   data="villageId: {{troopDetails.movement.villageIdStart}}, villageName: {{troopDetails.movement.villageNameStart}}">
						RallyPoint.Troops.Transit.Incoming.Tributes
					</span>
					<span translate ng-if="troopDetails.movement.movementType != Troops.MOVEMENT_TYPE_TRIBUTE_COLLECT && ['3','4','47','36'].indexOf(''+troopDetails.movement.movementType) > -1"
							   data="villageId: {{troopDetails.movement.villageIdStart}}, villageName: {{troopDetails.movement.villageNameStart}},
							   playerId: {{troopDetails.playerId}}, playerName: {{troopDetails.playerName}}" options="{{troopDetails.movement.movementType}}">
						RallyPoint.Troops.Transit.Incoming.MovementType_?
					</span>
					<span translate ng-if="troopDetails.movement.movementType != Troops.MOVEMENT_TYPE_TRIBUTE_COLLECT && ['3','4','47','36'].indexOf(''+troopDetails.movement.movementType) == -1"
							   data="villageId: {{troopDetails.movement.villageIdStart}}, villageName: {{troopDetails.movement.villageNameStart}},
							   playerId: {{troopDetails.playerId}}, playerName: {{troopDetails.playerName}}">
						RallyPoint.Troops.Transit.Incoming
					</span>
				</span>
				<span ng-if="oasis">
					<span translate data="villageId: {{troopDetails.villageIdLocation}}, villageName: {{troopDetails.villageNameLocation}}">RallyPoint.Troops.Transit.Incoming.Oasis</span>
				</span>
			</div>
			<div ng-if="status == 'outgoing'">
				<i class="movement outgoing {{movementIcon}}" tooltip tooltip-translate="TroopMovementInfo_{{movementGroup}}" tooltip-placement="above"></i>
				<span translate ng-if="!settle"
						   data="villageId: {{troopDetails.villageIdLocation}}, villageName: {{troopDetails.villageNameLocation}},
							   villageNameTarget: {{troopDetails.movement.villageNameTarget}},
							   playerId: {{troopDetails.movement.playerIdTarget}}, playerName: {{troopDetails.playerNameLocation}}" options="{{troopDetails.movement.movementType}}">
					RallyPoint.Troops.Transit.Outgoing.MovementType_?
				</span>
				<span translate ng-if="settle"
						   data="villageId: {{troopDetails.villageIdLocation}}, villageName: {{troopDetails.villageNameLocation}}"
						   options="{{troopDetails.movement.movementType}}">
					RallyPoint.Troops.Transit.Outgoing.MovementType_?
				</span>
			</div>
		</div>
		<div class="troopsInfo {{status}}Info" ng-if="status != 'send'">
			<span class="merchantsRecurrences" ng-if="troopDetails.movement.recurrencesTotal > 1" ng-bind-html="troopsDetails.movement.recurrences | bidiRatio : troopDetails.movement.recurrences : troopDetails.movement.recurrencesTotal"></span>
			<div ng-if="troopDetails.status == 'transit'" class="countdownContainer">
				<span translate ng-if="troopDetails.movement.merchants > 0" tooltip tooltip-data="timeFinish: {{troopDetails.movement.timeFinish}}" tooltip-translate="RallyPoint.Troops.ArrivalTime.Trade.Tooltip" class="countdownTo" data="timeFinish: {{troopDetails.movement.timeFinish}}">RallyPoint.Troops.ArrivalTime.Trade</span>
				<span translate ng-if="troopDetails.movement.merchants == 0" class="countdownTo" data="timeFinish: {{troopDetails.movement.timeFinish}}">RallyPoint.Troops.ArrivalTime</span>
			</div>
			<div ng-if="(troopDetails.status != 'transit' && troopDetails.status != 'trap' && troopDetails.status != 'send' && troopDetails.tribeId != tribes.NATURE) || (troopDetails.status == 'trap' && troopDetails.playerId == $root.player.data.playerId)" tooltip tooltip-translate="Resource.CropConsumption">
				<span class="text"><i class="unit_consumption_small_flat_black"></i> {{troopDetails.supplyTroops}} <span translate>perHour</span></span>
			</div>
			<div class="markerContainer" ng-if="status == 'incoming'">
				<i clickable="changeMarker({{troopDetails.troopId}})" class="marker movement_incoming_attack_marker_{{markerColor}}_medium_illu"></i>
			</div>
		</div>
	</div>

	<div troops-details ng-if="showUnits" troop-data="troopDetails" render-lazy="{{renderLazy}}"></div>

	<div class="additionalTroopInfos" ng-if="showCatapults || showSpy || showBounty">
		<div ng-if="showCatapults">
			<span ng-if="troopDetails.movement.catapultTarget2 > 0">
				<span translate>RallyPoint.Troops.Targets</span>
				<span options="{{troopDetails.movement.catapultTarget1}}" translate>Building_?</span>,
				<span options="{{troopDetails.movement.catapultTarget2}}" translate>Building_?</span>
			</span>
			<span ng-if="troopDetails.movement.catapultTarget2 == 0">
				<span translate>RallyPoint.Troops.Target</span>
				<span options="{{troopDetails.movement.catapultTarget1}}" translate>Building_?</span>
			</span>
		</div>
		<div ng-if="showSpy">
			<span options="{{troopDetails.movement.spyTarget}}" translate>RallyPoint.SendTroops.SpyOption_?</span>
		</div>
		<div ng-if="showBounty" ng-class="{withInstantDelivery: showInstantDelivery}" class="bounty">
			<div ng-if="troopDetails.movement.merchants > 1" class="merchantCount">
				<i class="movement_trade_small_flat_black"></i> {{troopDetails.movement.merchants}}
			</div>
			<display-resources ng-if="troopDetails.movement.treasures > 0 && !showStolenGoods"
							   resources="troopDetails.movement.resources"
							   treasures="troopDetails.movement.treasures"></display-resources>
			<display-resources ng-if="troopDetails.movement.treasures > 0 && showStolenGoods"
							   resources="troopDetails.movement.resources"
							   stolen-goods="troopDetails.movement.treasures"></display-resources>
			<display-resources ng-if="troopDetails.movement.treasures == 0" resources="troopDetails.movement.resources" old="{{oldBounty}}"></display-resources>
			<span class="carryCapacity" ng-if="troopDetails.movement.merchants <= 0 && !hideCapacity">
				<i class="carry"
				   tooltip tooltip-translate="Report.CarryCapacityTooltip" tooltip-placement="above"
				   tooltip-data="percent:{{totalResources/troopDetails.capacity*100|number:0}},used:{{totalResources}},max:{{troopDetails.capacity}}"
				   ng-class="{
								unit_capacityEmpty_small_flat_black: totalResources == 0,
								unit_capacityHalf_small_flat_black: totalResources > 0 && totalResources < troopDetails.capacity,
								unit_capacity_small_flat_black: totalResources == troopDetails.capacity }"></i>
			{{0 | bidiRatio:totalResources:troopDetails.capacity}}
			</span>
			<button ng-if="showInstantDelivery"
					class="premium instantDelivery"
					premium-feature="{{premiumFeatureName}}"
					premium-callback-param="{{troopDetails.troopId}}"
					price="{{premiumFeaturePrice}}">
				<span translate>RallyPoint.Overview.InstantDelivery</span>
			</button>
		</div>
	</div>
	<div class="troopActions"
		 ng-if="isGroup || (showAction && !isGroup) || (showAbort && $root.currentServerTime <= abortButtonShowTime) || isAdventure">
		<a ng-if="isGroup" class="centered" clickable="callback({type: '{{status}}', tribe: {{troopDetails.tribeId}} })">
			<span translate>RallyPoint.TroopGroup.ShowAll</span>
		</a>
		<button ng-if="showAction && !isGroup" class="actionButton jsButtonSendTroopsBack" clickable="sendBack();">
			<span translate options="{{action}}">
				Troops.?Back
			</span>
		</button>
		<div ng-if="(showAbort && $root.currentServerTime <= abortButtonShowTime) || isAdventure">
			<span translate data="time: {{abortButtonShowTime}}" ng-if="!isAdventure">RallyPoint.Troops.Transit.AbortCountdown</span>
			<button class="abortTroopMovementButton cancel"
					clickable="abortMovement();"
					play-on-click="{{$root.UISound.BUTTON_CANCEL_TROOP_MOVEMENT}}">
				<span translate>Button.Abort</span>
			</button>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/user/login.html"><div id="mainPage" class="container" ng-controller="userMainPageCtrl">
	<div class="navigation">
		<div id="navigation-wrapper">
			<div class="cheatLogin" ng-if="showCheatLogin">
				<form class="form-horizontal" ng-controller="userLoginCtrl">
					<input type="text" id="loginInputUsername" placeholder="Username" ng-model="username" />
					<input type="password" id="loginInputPassword" placeholder="Password" ng-model="password" class="passwordInput" />
					<button type="submit" clickable="doLogin(username,password)" ng-class="{'disabled': registrationInProgress }" ><span translate>SignIn</span></button>
					<div ng-if="useMellon">
						<div class="registerButton" ng-if="config.SERVER_ENV != 'live'">
							<input type="text" id="randomUserName"  ng-model="randomUserName" />
							<button clickable="doCheatRegistration(randomUserName);" ng-class="{ 'disabled': randomUserName.length > 9 || registrationInProgress}">Register an new Player</button>
						</div>
						<div class="registerButton" ng-if="config.SERVER_ENV != 'live'">
							<button clickable="mellonRegister();" ng-class="{'disabled': registrationInProgress }" ><span class="content">PlayNow with mellon</span></button>
						</div>
						<div class="registerButton" ng-if="config.SERVER_ENV != 'live'">
							<button clickable="mellonLogin();" ng-class="{'disabled': registrationInProgress }" ><span class="content">Login with mellon</span></button>
						</div>
					</div>
					<button type="submit" clickable="toPortal();" ng-class="{'disabled': registrationInProgress }" >GoToPortal</button>
				</form>
			</div>
			<div ng-if="!showCheatLogin">
				<button type="submit" clickable="toPortal();" ng-class="{'disabled': registrationInProgress }" >GoToPortal</button>
			</div>

            <div ng-if="!useMellon">
                <div class="loginButton">
                    <button clickable="showPopup('login');" ng-class="{'disabled': registrationInProgress }" ><span translate>Login</span></button>
                </div>
                <div class="registerButton" ng-if="config.SERVER_ENV != 'live'">
                    <button clickable="showPopup('register');" ng-class="{'disabled': registrationInProgress }" ><span translate>Register</span></button>
                </div>
                <div class="registerButton">
                    <button clickable="startPlaying();" ng-class="{'disabled': registrationInProgress }" ><span translate>PlayNow</span></button>
                </div>
            </div>
		</div>
	</div>
	<div id="overlaybg" ng-show="popup != 'none'"></div>
	<div class="popup" ng-if="popup != 'none'">
		<div class="closeButton">
			<button clickable="closePopup();">X</button>
		</div>
		<div class="popupContent">
			<div class="login full" ng-if="popup == 'login'">
				<div ng-if="!useMellon" ng-controller="userLoginCtrl">
					<div ng-include src="'tpl/user/loginForm.html'"></div>
				</div>
			</div>
			<div class="error" ng-if="popup == 'error'">
				{{registerError}}
			</div>
			<div class="login full" ng-if="popup == 'selectTribe'">
				<div ng-include src="'tpl/user/selectTribe.html'"></div>
			</div>
		</div>
	</div>
</div>

</script>
<script type="text/ng-template" id="tpl/user/loginForm.html"><div ng-controller="userLoginCtrl" class="span6">
	<h3 translate>Login</h3>

	<form class="form-horizontal" ng-hide="loggedIn">
		<div class="alert alert-error" ng-show="error != false" translate
			options="{{error}}">?</div>
		<div class="control-group">
			<label class="control-label" for="loginInputUsername" translate>Username</label>

			<div class="controls">
				<input type="text" id="loginInputUsername" placeholder="Username"
					ng-model="username" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="loginInputPassword" translate>Password</label>

			<div class="controls">
				<input type="password" id="loginInputPassword"
					placeholder="Password" ng-model="password" />
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label>
					<input type="checkbox">
					<span translate>RememberMe</span>
				</label><br>
				<button type="submit" clickable="doLogin(username,password)"><span translate>SignIn</span></button>
			</div>
		</div>
	</form>
	<div class="alert alert-success" ng-show="loggedIn" translate>AlreadySignIn</div>
</div></script>
<script type="text/ng-template" id="tpl/user/profile.html"><h3>User Profil</h3></script>
<script type="text/ng-template" id="tpl/user/selectTribe.html"><h2 translate>Player.SelectTribeTitle</h2>
<div class="startTribeSelection">
	<p translate>Player.TribeSelection</p>

	<div class="tribeContainer">
		<div class="tribe tribe{{t}}" ng-repeat="t in [3,1,2]" ng-class="{selected: input.tribe == t}" clickable="input.tribe={{t}}">
		</div>
	</div>

	<div class="tribeDescription">
		<div class="arrowToTribe tribe{{input.tribe}}"></div>
		<h4 translate options="{{input.tribe}}">Tribe_?</h4>
	</div>
	<div>
		<button clickable="startPlaying()"><span translate>Player.SelectTribe</span></button>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/user/sitterRightsTooltip.html"><div class="sitterRightsTooltip">
	<div class="headline" translate>Sitter.LoggedInAs</div>
	<span translate>Sitter.YourRights</span>
	<div class="horizontalLine"></div>
	<div class="radio" ng-repeat="(permission,enabled) in permissions">
		<label>
			<input type="checkbox" disabled class="disabled" ng-model="permissions[permission]">
			<span translate options="{{permission}}">Sitter.Permission_?</span>
		</label>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/user/partials/avatar_image.html"><div class="heroImage {{gender}}" ng-class="::class" rerender="rerender">
	<img class="npcKing tribe_robber_illustration" src="layout/images/x.gif" ng-if="playerId == robberId" />
</div>
</script>
<script type="text/ng-template" id="tpl/villagesOverview/CulturePoints.html"><div ng-controller="villageOverviewCulturePointsCtrl" class="cpOverview">
	<table class="villagesTable lined">
		<thead>
			<tr>
				<th translate>Troops.VillageName</th>
				<th translate>VillagesOverview.CulturePointsPerDay</th>
				<th translate>Celebrations</th>
				<th translate>Units</th>
				<th translate>ExpansionSlots.ExpansionList.Slots</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="village in culturePointList | orderBy:'villageName'"  ng-class="{activeVillage:activeVillageId == village.villageId}">
				<td>
					<div class="longTitle"><a clickable="setVillage(village.villageId)" class="truncated">{{village.villageName}}</a></div>
				</td>
				<td>{{village.culturePointProduction}}</td>
				<td>
					<span ng-if="celebrationData[village.villageId].count > 0">
						<i ng-repeat="celeb in celebrationData[village.villageId].queue" class="unit_culturePoint_small_illu" tooltip tooltip-translate="celebrationTitle_{{celeb.type}}"></i>
						<span ng-if="celebrationData[village.villageId].count > 0" countdown="{{celebrationData[village.villageId].timeEnd}}"></span>
					</span>
					<span ng-if="village.celebration == 0"><a clickable="goToTownHall({{village.villageId}})" translate>Building_24</a></span>
					<span ng-if="village.celebration < 0">-</span>
				</td>
				<td>
					<span ng-if="village.units.length <= 0">-</span>
					<span unit-icon ng-repeat="unit in village.units track by $index"
							   data="tribeId, village.units[$index]"
							   tooltip tooltip-translate="Troop_{{((tribeId-1)*10)+village.units[$index]}}"></span>
				</td>
				<td>{{0 | bidiRatio:village.slots.used:village.slots.available}}</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td translate>
					Total
				</td>
				<td>{{cpListTotal.culturePointProduction}}</td>
				<td>
					<span>-</span>
				</td>
				<td>
					{{cpListTotal.units}}
				</td>
				<td>{{0 | bidiRatio:cpListTotal.slots.used:cpListTotal.slots.available}}</td>
			</tr>
		</tfoot>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/Oases.html"><div ng-controller="villageOverviewOasesCtrl" class="oasesOverview">
	<table class="villagesTable lined">
		<thead>
			<tr>
				<th translate>VillagesOverview.VillageName</th>
				<th translate colspan="2">Troops</th>
				<th class="coordinates"><i class="symbol_target_small_flat_black"></i></th>
				<th translate>Rank</th>
				<th translate>Resources</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="oases in oasesList" ng-if="oases.data.usedByVillage != 0 && oases.data.rank > 0" ng-init="$parent.$parent.anyOasisInUse=true">
				<td><span village-link villageid="{{oases.data.usedByVillage}}" villagename=""></span></td>
				<td class="iconCol"><i class="generalTroops"></i></td>
				<td> {{troopAmountInVillage[oases.data.oasisId] || 0}}</td>
				<td class="coordinates"><div coordinates x="id" y="{{oases.data.oasisId}}"></div></td>
				<td>{{oases.data.rank}}</td>
				<td><span ng-repeat="(resId, bonus) in oases.data.bonus" ng-if="bonus > 0" class="oasisBonus"><i class="unit_{{resNames[resId]}}_small_illu"></i>{{bonus | bidiNumber:"percent"}}</span></td>
			</tr>
		</tbody>
	</table>
	<div ng-if="!anyOasisInUse" >
		<br><span translate>VillagesOverview.Oases.noUsedOases</span>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/villagesOverview/Overview.html"><div ng-controller="villagesOverviewMainCtrl" class="mainOverview">
	<table class="villagesTable lined">
		<thead>
			<tr>
				<th translate>VillagesOverview.VillageName</th>
				<th translate>VillagesOverview.Incoming</th>
				<th translate>VillagesOverview.Outgoing</th>
				<th translate>VillagesOverview.Building</th>
				<th translate>VillagesOverview.Troops</th>
				<th ng-if="config.balancing.features.finishNowAll"></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="village in overview | orderBy:'villageName'" ng-class="{activeVillage:activeVillageId == village.villageId}">
				<td>
					<a clickable="setVillage(village.villageId)" class="truncated">{{village.villageName}}</a>
				</td>
				<td>
					<i class="movement_attack_small_flat_black" ng-if="village.attacks.underAttack > 0" tooltip tooltip-translate="VillagesOverview.Tooltip.IncomingAttacks" tooltip-data="count:{{village.attacks.underAttack}}"></i>
					<div ng-show="village.attacks.underAttack <= 0">-</div>
				</td>
				<td>
					<i class="movement_attack_small_flat_black" ng-if="village.attacks.attacking > 0" tooltip tooltip-translate="VillagesOverview.Tooltip.OutgoingAttacks" tooltip-data="count:{{village.attacks.attacking}}"></i>
					<div ng-show="village.attacks.attacking <= 0">-</div>
				</td>
				<td>
					<i ng-class="{feature_buildingQueue_small_illu: building.queueType != BuildingQueue.TYPE_MASTER_BUILDER,
								  feature_buildingMaster_small_illu: building.queueType == BuildingQueue.TYPE_MASTER_BUILDER}"
					   ng-repeat="building in village.buildingQueue | orderBy:['queueType!=4', '-queuePosition', '-finished']"
					   tooltip tooltip-url="tpl/villagesOverview/partials/constructionTooltip.html"
					   clickable="openBuilding(building.locationId, village.villageId)"></i>
					<div ng-if="village.buildingQueue.length <= 0">-</div>
				</td>
				<td class="troopsProduction">
					<building-quicklinks village-id="{{village.villageId}}" show-active></building-quicklinks>
					<i ng-if="village.smithyQueue" clickable="openBuildingByType(13, village.villageId)" tooltip tooltip-translate="Building_13" class="building_g13_small_flat_black"></i>
					<i ng-if="village.academyQueue" clickable="openBuildingByType(22, village.villageId)" tooltip tooltip-translate="Building_22" class="building_g22_small_flat_black"></i>
				</td>
				<td ng-if="config.balancing.features.finishNowAll">
					<div class="iconButton premium" premium-feature="{{::FinishNowFeatureName}}"
						 premium-callback-param="finishNowVillageId:{{village.villageId}}"
						 price="{{config.balancing.PremiumFeatures.finishNow.priceAll}}"
						 confirm-gold-usage="true"
						 tooltip tooltip-url="tpl/npcTrader/finishNowTooltip.html">
						<i class="feature_instantCompletion_small_flat_black"></i>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</script>
<script type="text/ng-template" id="tpl/villagesOverview/Resources.html"><div ng-controller="villagesOverviewResourcesAndStoreCtrl" class="resourcesOverview">
	<table class="villagesTable lined">
		<thead>
			<tr>
				<th translate>VillagesOverview.VillageName</th>
				<th class="resource"><i class="unit_wood_small_illu" tooltip tooltip-translate="wood"></i></th>
				<th class="resource"><i class="unit_clay_small_illu" tooltip tooltip-translate="clay"></i></th>
				<th class="resource"><i class="unit_iron_small_illu" tooltip tooltip-translate="iron"></i></th>
				<th class="resource"><i class="unit_crop_small_illu" tooltip tooltip-translate="crop"></i></th>
				<th translate>VillagesOverview.Merchants</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="village in overview | orderBy:'villageName'" ng-class="{activeVillage:activeVillageId == village.villageId}">
				<td>
					<div class="longTitle"><a clickable="setVillage(village.villageId)" class="truncated">{{village.villageName}}</a></div>
				</td>
				<td ng-repeat="resource in village.resources track by $index"
					tooltip tooltip-class="storageTooltip" tooltip-translate="Ratio"
					tooltip-data="value: {{resource}}, total: {{village.storageCapacity[$index + 1]}}">
					{{resource}}
				</td>
				<td>
					<a clickable="openMarketPlace(village.villageId)" ng-if="village.merchants.total > 0">{{0 | bidiRatio:village.merchants.free:village.merchants.total}}</a>
					<div ng-if="village.merchants.total <= 0">-</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td translate>Total</td>
				<td ng-repeat="resource in total.resources track by $index">
					{{resource}}
				</td>
				<td>
					{{0 | bidiRatio:total.merchants.free:total.merchants.total}}
				</td>
			</tr>
		</tfoot>


	</table>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/Store.html"><div ng-controller="villagesOverviewResourcesAndStoreCtrl" class="storeOverview">
	<table class="villagesTable lined">
		<thead>
			<tr>
				<th translate>VillagesOverview.VillageName</th>
				<th class="resource"><i class="unit_wood_small_illu" tooltip tooltip-translate="wood"></i></th>
				<th class="resource"><i class="unit_clay_small_illu" tooltip tooltip-translate="clay"></i></th>
				<th class="resource"><i class="unit_iron_small_illu" tooltip tooltip-translate="iron"></i></th>
				<th><i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="VillagesOverview.DurationTillFull"></i></th>
				<th class="resource"><i class="unit_crop_small_illu" tooltip tooltip-translate="crop"></i></th>
				<th><i class="symbol_clock_small_flat_black duration" tooltip tooltip-translate="VillagesOverview.DurationTillFull"></i></th>
			</tr>
		</thead>
		<tbody>
		<tr ng-repeat="village in overview | orderBy:'villageName'" ng-class="{activeVillage:activeVillageId == village.villageId}">
			<td>
				<div class="longTitle"><a clickable="setVillage(village.villageId)" class="truncated">{{village.villageName}}</a></div>
			</td>
			<td ng-class="{attention: village.fillPercentage[1] >= 95}"
				tooltip tooltip-class="storageTooltip" tooltip-translate="Ratio"
				tooltip-data="value: {{village.resources[1]}}, total: {{village.storageCapacity[1]}}">
				{{village.fillPercentage[1] | bidiNumber:'percent':false:false}}
			</td>
			<td ng-class="{attention: village.fillPercentage[2] >= 95}"
				tooltip tooltip-class="storageTooltip" tooltip-translate="Ratio"
				tooltip-data="value: {{village.resources[2]}}, total: {{village.storageCapacity[2]}}">
				{{village.fillPercentage[2] | bidiNumber:'percent':false:false}}
			</td>
			<td ng-class="{attention: village.fillPercentage[3] >= 95}"
				tooltip tooltip-class="storageTooltip" tooltip-translate="Ratio"
				tooltip-data="value: {{village.resources[3]}}, total: {{village.storageCapacity[3]}}">
				{{village.fillPercentage[3] | bidiNumber:'percent':false:false}}
			</td>
			<td>
				<div countdown="{{village.timeWhenFull.all}}" ng-if="village.timeWhenFull.all > currentServerTime"></div>
				<div ng-if="village.timeWhenFull.all <= currentServerTime">-</div>
			</td>
			<td ng-class="{attention: village.fillPercentage[4] >= 95}"
				tooltip tooltip-class="storageTooltip" tooltip-translate="Ratio"
				tooltip-data="value: {{village.resources[4]}}, total: {{village.storageCapacity[4]}}">
				{{village.fillPercentage[4] | bidiNumber:'percent':false:false}}
			</td>
			<td>
				<div countdown="{{village.timeWhenFull.crop}}" ng-if="village.timeWhenFull.crop > currentServerTime" ng-class="{attention: village.cropProductionSpeed < 0}"></div>
				<div ng-if="village.timeWhenFull.crop <= currentServerTime">-</div>
			</td>
		</tr>
		</tbody>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/Troops.html"><div ng-controller="villagesOverviewTroopsCtrl">
	<div tabulation tab-config-name="villageOverviewTabConfig">
		<div ng-include="tabBody_subtab"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/villagesOverview.html"><div ng-controller="villagesOverviewCtrl">
	<div ng-include="tabBody" class="villagesOverview"></div>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/partials/activeBuildings.html"><i clickable="gotoBuilding({{item.locationId}})"
   ng-repeat="item in unitBuilding"
   tooltip tooltip-url="tpl/mainlayout/partials/unitQueueTooltip.html"
   on-pointer-over="g{{item.buildingType}}Hover = true" on-pointer-out="g{{item.buildingType}}Hover = false"
   ng-if="item.state == 'active'"
   ng-class="{building_g{{item.buildingType}}_small_flat_black: !g{{item.buildingType}}Hover, building_g{{item.buildingType}}_small_flat_green: g{{item.buildingType}}Hover}"
   on-pointer-over="g{{item.buildingType}}Hover = true" on-pointer-out="g{{item.buildingType}}Hover = false">
</i></script>
<script type="text/ng-template" id="tpl/villagesOverview/partials/constructionTooltip.html"><div class="constructionTooltip">
	<span translate options="{{building.buildingType}}">Building_?</span>
	<span translate class="finishTime" data="countdownTo:{{building.finished}}">countdownTo</span>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/troops/tabs/OwnTroops.html"><div class="ownTroops">
	<table class="villagesTable lined">
		<thead class="troopsIconRow">
			<tr>
				<th translate>Troops.VillageName</th>
				<th ng-repeat="n in []|range:1:11">
					<span unit-icon data="{{n == 11 ? 'hero' : n+(ownTroops[0].tribeId-1)*10}}"
							   tooltip tooltip-translate="Troop_{{n == 11 ? 'hero' : n+(ownTroops[0].tribeId-1)*10}}" tooltip-placement="above"></span>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="village in ownTroops | orderBy:'villageName'">
				<td>
					<a clickable="setVillage(village.villageId)" class="truncated">{{village.villageName}}</a>
				</td>
				<td ng-repeat="(troopId, troop) in village.troops track by $index">{{troop}}</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td translate>Total</td>
				<td ng-repeat="troop in totalTroops track by $index">{{troop}}</td>
			</tr>
		</tfoot>
	</table>
</div></script>
<script type="text/ng-template" id="tpl/villagesOverview/troops/tabs/TroopsInVillages.html"><div class="troopsInVillages">
	<div class="troopsDetailContainer" ng-repeat="village in troopsInVillage">
		<div class="troopsDetailHeader">
			<span translate>VillagesOverview.TroopsInVillage</span> <span village-link villageId="{{village.villageId}}" villageName="{{village.villageName}}" class="truncated"></span>
			<div class="troopsInfo" tooltip tooltip-translate="Resource.CropConsumption">
				<span><i class="unit_consumption_small_flat_black"></i> {{village.supplyTroops}} <span translate>perHour</span></span>
			</div>
		</div>
		<div troops-details ng-repeat="troops in village.troops" troop-data="troops"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/welcomePackage/welcomePackage.html"><div class="welcomePackageContent" ng-controller="welcomePackageCtrl">
	<div class="backgroundFlare rotate">
		<div class="flareRay" ng-repeat="n in []|range:0:10"></div>
	</div>
	<div class="wrapper">
		<div class="backgroundTop modalDecoration coopPackage_bgTop_layout">
			<i clickable="close()" class="close action_cancel_small_flat_black"></i>
		</div>
		<div class="backgroundMiddle modalContent" scrollable height-dependency="max">
			<div translate>WelcomePackage.Header</div>
			<div class="divider coopPackage_divider_layout"></div>
			<div ng-repeat="item in packageInfo">
				<reward type="item.type" value="item.amount" size="medium" class="reward"></reward>
			</div>
			<div class="divider"></div>
			<div translate>WelcomePackage.Footer</div>
			<button clickable="close()">
				<span translate>Next</span>
			</button>
		</div>
		<div class="coopPackage_bgBottom_layout"></div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/worldEnded/memberListOverlay.html"><div pagination display-page-func="displayCurrentPage"
			startup-position="{{ownPosition}}"
			items-per-page="itemsPerPage"
			number-of-items="numberOfItems"
			current-page="currentPage"
			route-named-param="cp">
	<table class="memberTable">
		<thead>
			<tr class="member">
				<th translate colspan="2">TableHeader.Player</th>
				<th class="villages"><i class="village_village_small_flat_black" tooltip tooltip-translate="Villages"></i></th>
				<th class="population"><i class="unit_population_small_flat_black" tooltip tooltip-translate="Population"></i></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="m in members"
				class="member">
				<td class="rank">
					{{m.rank}}.
				</td>
				<td class="playerName">
					<div class="longTitle">
						<span player-link playerId="{{m.playerId}}" playerName="{{m.name}}"></span>
					</div>
				</td>
				<td class="villages">
					<span class="content">{{ m.villages }}</span>
				</td>
				<td class="population">
					<span class="content">{{ m.population|number:0}}</span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</script>
<script type="text/ng-template" id="tpl/worldEnded/worldEnded.html"><div ng-controller="worldEndedCtrl">
	<div ng-include="tabBody_tab"></div>
</div></script>
<script type="text/ng-template" id="tpl/worldEnded/partials/bonusTooltip.html"><div class="worldEndPrestigeBonusTooltip">
    <b ng-if="!noHeader">
        {{title}}
    </b>
    <div ng-if="!noHeader" class="horizontalLine"></div>
    <div ng-if="custom == 'true'">
        {{customText}}
    </div>
    <div ng-if="custom != 'true'">
        <table class="transparent">
            <tr>
                <td class="rowTitle">
                    <span translate>WorldEndPrestige.Tooltip.EarnedPrestige</span>
                </td>
                <td>
                    <span>{{earnedPrestige}}</span>
                </td>
            </tr>
            <tr>
                <td class="rowTitle">
                    <span>{{title}}</span>
                </td>
                <td>
                    <span>{{bonusPercent | bidiNumber:'percent':true:true}}</span>
                </td>
            </tr>
            <tr>
                <td class="rowTitle">
                    <span translate>WorldEndPrestige.Tooltip.TotalGained</span>
                </td>
                <td>
                    <span>{{totalGained}}</span>
                </td>
            </tr>
        </table>

    </div>
</div></script>
<script type="text/ng-template" id="tpl/worldEnded/tabs/AllianceRanking.html"><div class="rankingEntryBox rank1 alliance">
	<i class="header alliance rank1"></i>
	<div class="content">
		<div class="headerRow">
			<i class="unit_victoryPoints_small_flat_black"></i>{{alliances[0].points}}
		</div>
		<div class="horizontalLine"></div>
		<div class="name">
			<alliance-link allianceId="{{alliances[0].allianceId}}" allianceName="{{alliances[0].tag}}"></alliance-link>
			<br>
			{{alliances[0].allianceName}}
		</div>
		<div class="horizontalLine belowRank1"></div>
		<div class="horizontalLine belowRank4"></div>
		<div class="king rank{{$index+1}}" ng-repeat="king in alliances[0].kings">
			<div class="playerHead">
				<avatar-image scale="0.62" player-id="{{king.playerId}}" class="avatar"></avatar-image>
			</div>
			<br>
			<span player-link playerId="{{king.playerId}}" playerName="{{king.playerName}}"></span>
			<br>
			<div class="governorCount" translate data="count: {{king.governors}}">WorldEnded.Alliance.Governors</div>
		</div>
		<div class="showAll">
			<div class="horizontalLine"></div>
			<span clickable="openOverlay('allianceMemberList', {allianceId: alliances[0].allianceId})" translate>WorldEnded.Alliance.ShowAll</span>
		</div>
	</div>
</div>
<div ng-repeat="r in [2,3]" class="rankingEntryBox rank{{r}} alliance">
	<i class="header alliance rank{{$index+2}}"></i>
	<div class="content">
		<div class="headerRow">
			<i class="unit_victoryPoints_small_flat_black"></i>{{alliances[$index+1].points}}
		</div>
		<div class="horizontalLine"></div>
		<div class="name truncated">
			<alliance-link allianceId="{{alliances[$index+1].allianceId}}" allianceName="{{alliances[$index+1].tag}}"></alliance-link>
			<br>
			{{alliances[$index+1].allianceName}}
		</div>
		<div class="horizontalLine"></div>
		<div ng-repeat="king in alliances[$index+1].kings">
			<span player-link playerId="{{king.playerId}}" playerName="{{king.playerName}}"></span>
		</div>
		<div class="horizontalLine"></div>
		<div class="showAll">
			<div class="horizontalLine"></div>
			<span clickable="openOverlay('allianceMemberList', {allianceId: {{alliances[$index+1].allianceId}} })" translate>WorldEnded.Alliance.ShowAll</span>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/worldEnded/tabs/KingdomRanking.html"><div ng-repeat="r in kingdomRankings" class="rankingEntryBox player kingdom">
	<i class="header kingdom {{r.type}}"></i>
	<div class="content">
		<div class="headerRow">
			<span translate options="{{r.type}}">WorldEnded.Kingdom_?</span>
		</div>
		<div class="entry" ng-repeat="entry in r.ranking">
			<div class="horizontalLine"></div>
			<div class="playerHead">
				<avatar-image scale="0.62" player-id="{{entry.playerId}}" class="avatar"></avatar-image>
			</div>
			<div class="data truncated">
				{{entry.rank|rank}}.<span player-link playerId="{{entry.playerId}}" playerName="{{entry.playerName}}"></span>
				<div class="points">
					<i class="{{r.icon}}"></i>{{entry.points | number}}
				</div>
			</div>
			<div class="endGamePrestigeStars" ng-if="config.balancing.features.prestige" tooltip tooltip-translate="Prestige.Level">
				<prestige-stars stars="entry.stars" size="tiny"></prestige-stars>
			</div>
		</div>

		<div class="entry own" ng-if="ownKingdomRankings[r.type] != null && ownKingdomRankings[r.type].rank >= 10">
			<div class="horizontalLine"></div>
			<div class="playerHead">
				<avatar-image scale="0.62" player-id="{{ownKingdomRankings[r.type].playerId}}" class="avatar"></avatar-image>
			</div>
			<div class="data truncated">
				{{ownKingdomRankings[r.type].rank|rank}}.<span player-link playerId="{{ownKingdomRankings[r.type].playerId}}" playerName="{{ownKingdomRankings[r.type].playerName}}"></span>
				<div class="points">
					<i class="{{r.icon}}"></i>{{ownKingdomRankings[r.type].points | number}}
				</div>
			</div>
			<div class="endGamePrestigeStars" ng-if="config.balancing.features.prestige" tooltip tooltip-translate="Prestige.Level">
				<prestige-stars stars="ownKingdomRankings[r.type].stars" size="tiny"></prestige-stars>
			</div>
			<div class="horizontalLine"></div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/worldEnded/tabs/PlayerRanking.html"><div ng-repeat="r in playerRankings" class="rankingEntryBox player">
	<i class="header player {{r.type}}"></i>
	<div class="content">
		<div class="headerRow">
			<span translate options="{{r.type}}">WorldEnded.Player_?</span>
		</div>
		<div class="entry" ng-repeat="entry in r.ranking">
			<div class="horizontalLine"></div>
			<div class="playerHead">
				<avatar-image scale="0.62" player-id="{{entry.playerId}}" class="avatar"></avatar-image>
			</div>
			<div class="data truncated">
				{{entry.rank|rank}}.<span player-link playerId="{{entry.playerId}}" playerName="{{entry.playerName}}"></span>
				<div class="points">
					<i class="points"></i>{{entry.points | number}}
				</div>
			</div>
			<div class="endGamePrestigeStars" ng-if="config.balancing.features.prestige" tooltip tooltip-translate="Prestige.Level">
				<prestige-stars stars="entry.stars" size="tiny"></prestige-stars>
			</div>
		</div>

		<div class="entry own" ng-if="ownRankings[r.type] != null && ownRankings[r.type].rank >= 10">
			<div class="horizontalLine"></div>
			<div class="playerHead">
				<avatar-image scale="0.62" player-id="{{ownRankings[r.type].playerId}}" class="avatar"></avatar-image>
			</div>
			<div class="data truncated">
				{{ownRankings[r.type].rank|rank}}.<span player-link playerId="{{ownRankings[r.type].playerId}}" playerName="{{ownRankings[r.type].playerName}}"></span>
				<div class="points">
					<i class="points"></i>{{ownRankings[r.type].points | number}}
				</div>
			</div>
			<div class="endGamePrestigeStars" ng-if="config.balancing.features.prestige" tooltip tooltip-translate="Prestige.Level">
				<prestige-stars stars="ownRankings[r.type].stars" size="tiny"></prestige-stars>
			</div>
		</div>
	</div>
</div></script>
<script type="text/ng-template" id="tpl/worldEnded/tabs/Prestige.html"><div class="worldEndPrestige">
    <div class="rankingEntryBox prestigeSummary">
        <div class="header">
        </div>
        <div class="content summaryContent">
            <div class="summaryValues">
                <span translate class="summaryCongratulationsTextContainer"
                     data="prestige:{{totalServerPrestige}},serverName:{{serverName}}">WorldEndPrestige.CongratulationsText</span>
                <div class="horizontalLine"></div>
                <div class="summarySections">
                    <div class="weeklyPrestige">
                        {{prestige.weeklyPrestige}}
                        <br />
                        <span translate>WorldEndPrestige.Weekly</span>
                    </div>
                    <div class="bonusPrestige">
                        {{prestige.bonusPrestige | bidiNumber:'':true:true}}
                        <br />
                        <span translate>WorldEndPrestige.TotalBonus</span>
                    </div>
                    <div class="totalPrestige">
                        <b>{{prestige.bonusPrestige + prestige.weeklyPrestige}}</b>
                        <br />
                        <span translate data="prestige:{{player.data.prestige}}">WorldEndPrestige.Total</span>
                    </div>
                </div>
            </div>
            <div class="summaryChaplet">
                <div class="report_chaplet_big_illu"></div>
                <div class="prestigeStars">
                    <prestige-stars playerId="{{player.data.playerId}}" size="tiny"></prestige-stars>
                </div>
                <div class="prestigeStarsTooltip"
                     tooltip
					 tooltip-translate-switch="{
						'Prestige.Stars.Tooltip.Own': {{!!player.data.nextLevelPrestige}},
						'Prestige.Stars.Tooltip.Own.Max': {{!player.data.nextLevelPrestige}}
					 }"
                     ng-if="config.balancing.features.prestige"
                     clickable="openWindow('profile', {'playerId': playerId, 'profileTab': 'prestige'})"
                     tooltip-data="prestige:{{player.data.prestige}},nextLevelPrestige:{{player.data.nextLevelPrestige}}"></div>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <div class="rankingEntryBox prestigeWw" ng-class="{'hidden': !prestige.wwPrestige}">
        <div class="header prestigeCup report_cup_big_illu">
            <div class="points">{{prestige.wwPrestige | bidiNumber:'':true:true}}</div>
        </div>
        <div class="content">
            <div class="rankingTitle" translate>WorldEndPrestige.RankingName.WonderOfTheWorld</div>
            <div class="horizontalLine"></div>
            <div tooltip tooltip-url="tpl/worldEnded/partials/bonusTooltip.html" tooltip-data="custom:true,customText:{{wwTooltipText}},noHeader:true">
                <i class="feature_prestige_small_flat_black bonusPrestigeCupIcon"></i><span translate>WorldEndPrestige.Bonus</span>{{prestige.wwPrestige}}
            </div>
            <div class="horizontalLine"></div>
            <div>
                <span translate>WorldEndPrestige.Rank</span>{{prestige.wwRank}}
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <div class="rankingEntryBox">
        <div class="header prestigeCup report_cup_big_illu">
            <div class="points">{{prestige.alliancePrestige | bidiNumber:'':true:true}}</div>
        </div>
        <div class="content">
            <div class="rankingTitle" translate>WorldEndPrestige.RankingName.Alliance</div>
            <div class="horizontalLine"></div>
            <div tooltip tooltip-url="tpl/worldEnded/partials/bonusTooltip.html" tooltip-data="custom:{{!hasAlliancePrestige}},customText:{{allianceTooltipNoAllianceText}},title:{{allianceTooltipTitle}},earnedPrestige:{{prestige.weeklyPrestige}},bonusPercent:{{prestige.allianceBonus}},totalGained:{{prestige.alliancePrestige}}">
                <i class="feature_prestige_small_flat_black bonusPrestigeCupIcon"></i><span translate>WorldEndPrestige.Bonus</span>{{prestige.alliancePrestige}}
            </div>
            <div class="horizontalLine"></div>
            <div>
                <span translate>WorldEndPrestige.Rank</span>
                <span ng-if="prestige.allianceRank >= 0">{{prestige.allianceRank | rank}}</span>
                <span ng-if="prestige.allianceRank == -1"> - </span>
            </div>
        </div>
    </div>
    <div class="rankingEntryBox">
        <div class="header prestigeCup report_cup_big_illu">
            <div class="points">{{prestige.populationPrestige | bidiNumber:'':true:true}}</div>
        </div>
        <div class="content">
            <div class="rankingTitle" translate>WorldEndPrestige.RankingName.Population</div>
            <div class="horizontalLine"></div>
            <div tooltip tooltip-url="tpl/worldEnded/partials/bonusTooltip.html" tooltip-data="title:{{populationTooltipTitle}},earnedPrestige:{{prestige.weeklyPrestige}},bonusPercent:{{prestige.populationBonus}},totalGained:{{prestige.populationPrestige}}">
                <i class="feature_prestige_small_flat_black bonusPrestigeCupIcon"></i><span translate>WorldEndPrestige.Bonus</span>{{prestige.populationPrestige}}
            </div>
            <div class="horizontalLine"></div>
            <div>
                <span translate>WorldEndPrestige.Rank</span>
                <span ng-if="prestige.populationRank >= 0">{{prestige.populationRank | rank}}</span>
                <span ng-if="prestige.populationRank == -1"> - </span>
            </div>
        </div>
    </div>
    <div class="rankingEntryBox">
        <div class="header prestigeCup report_cup_big_illu">
            <div class="points">{{prestige.attackerPrestige | bidiNumber:'':true:true}}</div>
        </div>
        <div class="content">
            <div class="rankingTitle" translate>WorldEndPrestige.RankingName.Attacker</div>
            <div class="horizontalLine"></div>
            <div tooltip tooltip-url="tpl/worldEnded/partials/bonusTooltip.html" tooltip-data="title:{{attackerTooltipTitle}},earnedPrestige:{{prestige.weeklyPrestige}},bonusPercent:{{prestige.attackerBonus}},totalGained:{{prestige.attackerPrestige}}">
                <i class="feature_prestige_small_flat_black bonusPrestigeCupIcon"></i> <span translate>WorldEndPrestige.Bonus</span>{{prestige.attackerPrestige}}
            </div>
            <div class="horizontalLine"></div>
            <div>
                <span translate>WorldEndPrestige.Rank</span>
                <span ng-if="prestige.attackerRank >= 0">{{prestige.attackerRank | rank}}</span>
                <span ng-if="prestige.attackerRank == -1"> - </span>
            </div>
        </div>
    </div>
    <div class="rankingEntryBox">
        <div class="header prestigeCup report_cup_big_illu">
            <div class="points">{{prestige.defenderPrestige | bidiNumber:'':true:true}}</div>
        </div>
        <div class="content">
            <div class="rankingTitle" translate>WorldEndPrestige.RankingName.Defender</div>
            <div class="horizontalLine"></div>
            <div tooltip tooltip-url="tpl/worldEnded/partials/bonusTooltip.html" tooltip-data="title:{{defenderTooltipTitle}},earnedPrestige:{{prestige.weeklyPrestige}},bonusPercent:{{prestige.defenderBonus}},totalGained:{{prestige.defenderPrestige}}">
                <i class="feature_prestige_small_flat_black bonusPrestigeCupIcon"></i> <span translate>WorldEndPrestige.Bonus</span>{{prestige.defenderPrestige}}
            </div>
            <div class="horizontalLine"></div>
            <div>
                <span translate>WorldEndPrestige.Rank</span>
                <span ng-if="prestige.defenderRank >= 0">{{prestige.defenderRank | rank}}</span>
                <span ng-if="prestige.defenderRank == -1"> - </span>
            </div>
        </div>
    </div>
</div>
</script>
<script type="text/ng-template" id="tpl/worldEnded/tabs/WorldWonder.html"><div ng-repeat="r in [1,2,3,4,5,6,7]" class="rankingEntryBox rank{{r}}">
	<i class="header {{r < 4 ? 'endOfWorld_wwPlace'+r+'_large_illu' : 'endOfWorld_wwPlace4_large_illu'}}">
		<div class="number rank{{r}}">{{r}}</div>
	</i>
	<div class="content" ng-if="worldWonders[$index].playerId >= 100">
		<div class="headerRow">
			<span translate data="bonus: {{worldWonders[$index].bonus*100}}">WorldEnded.WW.Bonus</span>
		</div>
		<div class="horizontalLine"></div>
		<div class="level">
			<span translate data="level: {{worldWonders[$index].level}}">WorldEnded.WW.Level</span>
		</div>
		<div class="horizontalLine"></div>
		<div class="alliance">
			<alliance-link allianceId="{{worldWonders[$index].allianceId}}" allianceName="{{worldWonders[$index].allianceTag}}"></alliance-link>
			<br>
			<span class="truncated">{{worldWonders[$index].allianceName}}</span>
		</div>
		<div class="horizontalLine"></div>
		<div class="player">
			<span player-link playerId="{{worldWonders[$index].playerId}}" playerName="{{worldWonders[$index].playerName}}"></span>
		</div>
	</div>

	<div class="content" ng-if="worldWonders[$index].playerId < 100">
		<div class="headerRow">
			<span translate>WorldEnded.WW.NotUnlocked</span>
		</div>
		<div class="horizontalLine"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="tpl/worldEndedModal/worldEndedModal.html"><div ng-controller="worldEndedSummaryCtrl">
	<div clickable="openWindow('worldEnded')">
		<div class="headerBackground">
			<div class="worldWonder"></div>
		</div>
		<i class="winnerAlliance"></i>
		<div class="textBox">
			<h2 data="wwBuilderName:{{wwBuildName}}" translate>WorldEnded.Description.Title</h2>
			<div class="horizontalLine"></div>
			<div class="text" translate>WorldEnded.Description</div>
		</div>
	</div>
</div>
</script>
