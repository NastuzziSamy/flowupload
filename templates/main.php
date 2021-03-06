<div id="content" ng-app="app" class="app-files" role="main">
  <div id="app-navigation">
    <ul id="locations" class="with-icon" ng-controller="locations">
      <li flow-prevent-drop flow-drop flow-drag-enter="class='alert-success'" flow-drag-leave="class=''" ng-class="class" ng-controller="location" flow-init="init(location.id, location.location); beforeUploading" ng-style="style" ng-repeat="location in locations" ng-init="$last && reloadLocations()" id="location-{{location.id}}" class="collapsible locations">
        <button flow-prevent-drop flow-drop flow-drag-enter="class='alert-success'" flow-drag-leave="class=''" class="collapse"></button>

        <a href="#" class="icon-folder" ng-click="setLocation(location.id, $flow)">{{location.location}}</a>
        <ul>
    		  <li><a class="icon-add" href="#" flow-btn><?= $l->t('Upload a file'); ?></a></li>
    		  <li><a class="icon-add" href="#" flow-btn flow-directory ng-show="$flow.supportDirectory"><?= $l->t('Upload a whole folder'); ?></a></li>
        </ul>
      </li>

      <li id="app-navigation-entry-utils-add">
        <a href="#"><?= $l->t('New destination'); ?></a>
        <div class="app-navigation-entry-utils">
          <ul>
            <li id="app-navigation-entry-utils-create" class="app-navigation-entry-utils-menu-button"><button class="icon-add"></button></li>
          </ul>
        </div>
        <div class="app-navigation-entry-edit">
          <form>
            <input id="newLocationName" type="text" placeholder="<?= $l->t('Destination name'); ?>" ng-keydown="$event.keyCode === 13 && addNewLocation()">
            <input type="submit" value="" class="icon-close">
            <input ng-click="addNewLocation()" type="submit" value="" class="icon-checkmark">
          </form>
        </div>
      </li>
    </ul>

    <input id="currentLocation" type="hidden" />
  </div>

  <div ng-controller="flow" flow-init="beforeUploading" id="app-content" flow-prevent-drop ng-style="style" style="padding: 2.5%; width:auto">
    <h2 style="padding-bottom: 25px;"><?= $l->t('Transfers'); ?></h2>
    <p style="padding-bottom: 5px;">
      <a class="btn btn-small btn-success" ng-click="$flow.resume()"><?= $l->t('Upload'); ?></a>
      <a class="btn btn-small btn-danger" ng-click="$flow.pause()"><?= $l->t('Pause'); ?></a>
      <a class="btn btn-small btn-info" ng-click="$flow.cancel()"><?= $l->t('Cancel'); ?></a>
      <span class="label label-info"><?= $l->t('Size'); ?>: {{$flow.getSize() | bytes}}</span>
      <span class="label label-info" ng-if="$flow.isUploading()"><?= $l->t('Uploading'); ?>...</span>
    </p>
    <table class="table table-hover table-bordered table-striped" flow-transfers>
      <thead>
      <tr>
        <th style="width:5%">#</th>
        <th><?= $l->t('Name'); ?></th>
        <th style="width:10%"><?= $l->t('Size'); ?></th>
        <th style="width:20%"><?= $l->t('Progress'); ?></th>
      </tr>
      </thead>
      <tbody>
      <tr ng-repeat="file in $flow.files">
        <td>{{$index+1}}</td>
        <td title="UID: {{file.uniqueIdentifier}}">{{file.relativePath}}</td>
        <td title="Chunks: {{file.chunks.length}}"><span ng-if="file.isUploading()">{{file.size*file.progress() | bytes}}/</span>{{file.size | bytes}}</td>
        <td>
          <div class="btn-group" ng-if="!file.isComplete() || file.error()">
            <progress max="1" value="{{file.progress()}}" title="{{file.progress()}}" ng-if="file.isUploading()"></progress>
            <a class="btn btn-mini btn-warning" ng-click="file.pause()" ng-hide="file.paused">
              <?= $l->t('Pause'); ?>
            </a>
            <a class="btn btn-mini btn-warning" ng-click="file.resume()" ng-show="file.paused">
              <?= $l->t('Resume'); ?>
            </a>
            <a class="btn btn-mini btn-danger" ng-click="file.cancel()">
              <?= $l->t('Cancel'); ?>
            </a>
            <a class="btn btn-mini btn-info" ng-click="file.retry()" ng-show="file.error">
              <?= $l->t('Retry'); ?>
            </a>
          </div>
  	      <span ng-if="file.isComplete() && !file.error()"><?= $l->t('Completed'); ?></span>
        </td>
      </tr>
      </tbody>
    </table>
    <p><?= $l->t('The files will be saved in your home directory.'); ?></p>
 </div>
