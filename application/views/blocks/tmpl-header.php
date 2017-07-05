
<div ui-view="" id="app" class="lyt-2 ng-scope app-navbar-fixed app-sidebar-fixed app-sidebar-closed" ng-class="{'app-mobile' : app.isMobile, 'app-navbar-fixed' : app.layout.isNavbarFixed, 'app-sidebar-fixed' : app.layout.isSidebarFixed, 'app-sidebar-closed':app.layout.isSidebarClosed, 'app-footer-fixed':app.layout.isFooterFixed}" style="">

<header class="navbar navbar-default navbar-static-top hidden-print ng-scope">
    <!-- start: NAVBAR HEADER -->
    <div class="navbar-header">
        <button href="javascript:void(0)" class="menu-mobile-toggler btn no-radius pull-left hidden-md hidden-lg" id="horizontal-menu-toggler" ng-click="menuToggle()" v-pressable="">
            <i class="fa fa-bars"></i>
        </button>
        <button href="javascript:void(0)" class="sidebar-mobile-toggler btn no-radius pull-left hidden-md hidden-lg" id="sidebar-toggler" ng-click="toggle('sidebar')" v-pressable="">
            <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" ui-sref="app.dashboard" href="#/app/dashboard"> <img ng-src="assets/images/logo.png" alt="Packet" src="assets/images/logo.png"> </a>
        <a class="navbar-brand navbar-brand-collapsed" ui-sref="app.dashboard" href="#/app/dashboard"> <img ng-src="assets/images/logo-collapsed.png" alt="" src="assets/images/logo-collapsed.png"> </a>
        <button class="btn pull-right menu-toggler visible-xs-block" id="menu-toggler" ng-click="navbarCollapsed = !navbarCollapsed" v-pressable="">
            <i ng-class="navbarCollapsed ? 'fa fa-folder' : 'fa fa-folder-open'" class="fa fa-folder"></i> <small><i class="fa fa-caret-down margin-left-5"></i></small>      	
        </button>
    </div>
    <!-- end: NAVBAR HEADER -->
    <!-- start: NAVBAR COLLAPSE -->
    <div class="navbar-collapse collapse" uib-collapse="navbarCollapsed" ng-init="navbarCollapsed = true" off-click="navbarCollapsed = true" off-click-if="!navbarCollapsed" off-click-filter="'#menu-toggler'" aria-expanded="false" aria-hidden="true" style="height: 0px;">
        <ul class="nav navbar-left hidden-sm hidden-xs">
            <li class="sidebar-toggler-wrapper">
                <div>
                    <button href="javascript:void(0)" class="btn sidebar-toggler visible-md visible-lg" ng-click="app.layout.isSidebarClosed = !app.layout.isSidebarClosed" v-pressable="">
                        <i class="fa fa-bars"></i>
                    <v-ripple style="width: 36px; height: 36px; left: 3px; top: 2px;"></v-ripple></button>
                </div>
            </li>
            <li>
                <a ng-click="goFullscreen()"> <i class="fa fa-expand" ng-show="!isFullscreen"></i> <i class="fa fa-compress ng-hide" ng-show="isFullscreen"></i></a>
            </li>
            <li>
                <form role="search" class="navbar-form main-search ng-pristine ng-valid ng-submitted" style="">
                    <div class="form-group">
                        <input type="text" placeholder="Enter search text here..." class="form-control">
                        <button class="btn search-button" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="nav navbar-right ng-isolate-scope" ct-fullheight="window" data-ct-fullheight-exclusion="header" data-ct-fullheight-if="isSmallDevice" style="height: auto;">
            <!-- start: MESSAGES DROPDOWN -->
            <!-- /// controller:  'InboxCtrl' -  localtion: assets/js/controllers/InboxCtrl.js /// -->
            <li class="dropdown ng-scope" uib-dropdown="" on-toggle="toggled(open)" ng-controller="InboxCtrl">
                <a href="" class="dropdown-toggle" uib-dropdown-toggle="" aria-haspopup="true" aria-expanded="false">
                    <notification-icon count="scopeVariable" class="ng-isolate-scope"><div class="angular-notifications-container">
    <div class="angular-notifications-icon overlay" ng-show="notification.visible" style=""><div ng-hide="notification.hideCount" class="ng-binding">4</div></div>
    <div class="notification-inner">
        <ng-transclude>
                        <i class="fa fa-envelope ng-scope"></i>
                    </ng-transclude>
    </div>
</div></notification-icon>
                </a>
                <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large animated fadeInUpShort">
                    <li>
                        <span class="dropdown-header ng-scope" translate="topbar.messages.HEADER">Unread messages</span>
                    </li>
                    <li>
                        <div class="drop-down-wrapper ps-container">
                            <ul>
                                <!-- ngRepeat: message in messages | orderBy: 'date':true | limitTo:3 --><li class="unread ng-scope" ng-repeat="message in messages | orderBy: 'date':true | limitTo:3 ">
                                    <a href="javascript:;" ng-class="{ unread: !message.read }" class="unread">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <img ng-src="assets/images/avatar-8.jpg" alt="" class="img-responsive img-rounded" src="assets/images/avatar-8.jpg">
                                            </div>
                                            <div class="thread-content">
                                                <span class="author ng-binding">Mary Ferguson</span>
                                                <span class="preview ng-binding">Dear Ms. Clarks, I am a friend of Emily Little and she encouraged me to…</span>
                                                <span class="time ng-binding"> 03/10/2016 at 10:29PM</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end ngRepeat: message in messages | orderBy: 'date':true | limitTo:3 --><li class="unread ng-scope" ng-repeat="message in messages | orderBy: 'date':true | limitTo:3 ">
                                    <a href="javascript:;" ng-class="{ unread: !message.read }" class="unread">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <img ng-src="assets/images/avatar-3.jpg" alt="" class="img-responsive img-rounded" src="assets/images/avatar-3.jpg">
                                            </div>
                                            <div class="thread-content">
                                                <span class="author ng-binding">Steven Thompson</span>
                                                <span class="preview ng-binding">Hi Peter, I am very sorry for my behavior in the staff meeting this morning.…</span>
                                                <span class="time ng-binding"> 03/10/2016 at 10:29PM</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end ngRepeat: message in messages | orderBy: 'date':true | limitTo:3 --><li class="unread ng-scope" ng-repeat="message in messages | orderBy: 'date':true | limitTo:3 ">
                                    <a href="javascript:;" ng-class="{ unread: !message.read }" class="unread">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <img ng-src="assets/images/avatar-2.jpg" alt="" class="img-responsive img-rounded" src="assets/images/avatar-2.jpg">
                                            </div>
                                            <div class="thread-content">
                                                <span class="author ng-binding">Nicole Bell</span>
                                                <span class="preview ng-binding">Hi there! Are you available around 2pm today? I’d like to talk to you about…</span>
                                                <span class="time ng-binding"> 03/10/2016 at 10:29PM</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end ngRepeat: message in messages | orderBy: 'date':true | limitTo:3 -->

                            </ul>
                        </div>
                    </li>
                    <li class="view-all">
                        <a href="javascript:void(0)" translate="topbar.messages.SEEALL" class="ng-scope">See All</a>
                    </li>
                </ul>
            </li>
            <!-- end: MESSAGES DROPDOWN -->
            <!-- start: ACTIVITIES DROPDOWN -->
            <li class="dropdown" uib-dropdown="" on-toggle="toggled(open)">
                <a href="" class="dropdown-toggle" uib-dropdown-toggle="" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
                <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large animated fadeInUpShort">
                    <li>
                        <span class="dropdown-header ng-scope" translate="topbar.activities.HEADER">You have new notifications</span>
                    </li>
                    <li>
                        <div class="drop-down-wrapper ps-container">
                            <div class="list-group no-margin">
                                <a class="media list-group-item" href=""> <img class="img-circle" alt="..." src="assets/images/avatar-1.jpg"> <span class="media-body block no-margin"> Use awesome animate.css <small class="block text-grey">10 minutes ago</small> </span> </a>
                                <a class="media list-group-item" href=""> <span class="media-body block no-margin"> 1.0 initial released <small class="block text-grey">1 hour ago</small> </span> </a>
                            </div>
                        </div>
                    </li>
                    <li class="view-all">
                        <a href="javascript:void(0)" translate="topbar.activities.SEEALL" class="ng-scope">See All</a>
                    </li>
                </ul>
            </li>
            <!-- end: ACTIVITIES DROPDOWN -->
            <!-- start: LANGUAGE SWITCHER -->
            <li class="dropdown" uib-dropdown="" on-toggle="toggled(open)">
                <a href="" class="dropdown-toggle" uib-dropdown-toggle="" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us" ng-class="'flagstyle'| translate"></i><span class="ng-binding">&nbsp;English</span> </a>
                <ul role="menu" class="dropdown-menu dropdown-light animated fadeInUpShort ">
                    <!-- ngRepeat: (localeId, langName) in language.available --><li ng-repeat="(localeId, langName) in language.available" class="ng-scope">
                        <a ng-click="language.set(localeId, $event)" href="javascript:void(0)" class="menu-toggler ng-binding"> English </a>
                    </li><!-- end ngRepeat: (localeId, langName) in language.available --><li ng-repeat="(localeId, langName) in language.available" class="ng-scope">
                        <a ng-click="language.set(localeId, $event)" href="javascript:void(0)" class="menu-toggler ng-binding"> Italiano </a>
                    </li><!-- end ngRepeat: (localeId, langName) in language.available --><li ng-repeat="(localeId, langName) in language.available" class="ng-scope">
                        <a ng-click="language.set(localeId, $event)" href="javascript:void(0)" class="menu-toggler ng-binding"> Deutsch </a>
                    </li><!-- end ngRepeat: (localeId, langName) in language.available -->
                </ul>
            </li>
            <!-- end: LANGUAGE SWITCHER -->
        </ul>
        <!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
        <div class="close-handle visible-xs-block menu-toggler" ng-click="navbarCollapsed = true" ng-swipe-up="navbarCollapsed = true">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
        <!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
    </div>
    <button class="sidebar-mobile-toggler dropdown-off-sidebar btn hidden-md hidden-lg" ng-click="toggle('off-sidebar')" v-pressable="">
        &nbsp;
    </button>
    <button class="dropdown-off-sidebar btn hidden-sm hidden-xs" ng-click="toggle('off-sidebar')" v-pressable="">
        &nbsp;
    <v-ripple style="width: 59px; height: 59px; left: -10.5px; top: 5.5px;"></v-ripple></button>
    <!-- end: NAVBAR COLLAPSE -->
</header>

</div>