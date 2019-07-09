/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
$(function () {
  'use strict'

  // Create the new tab
  var $tabPane = $('<div />', {
    'id'   : 'control-sidebar-theme-demo-options-tab',
    'class': 'tab-pane active'
  })

  // Create the tab button
  var $tabButton = $('<li />', { 'class': 'active' })
    .html('<a href=\'#control-sidebar-theme-demo-options-tab\' data-toggle=\'tab\'>'
      + '<i class="fa fa-wrench"></i>'
      + '</a>')

  // Add the tab button to the right sidebar tabs
  $('[href="#control-sidebar-home-tab"]')
    .parent()
    .before($tabButton)

  // Create the menu
  var $demoSettings = $('<div />')


  $demoSettings.append(' <div class="tab-pane" id="control-sidebar-home-tab">'
        +'<h1 class="control-sidebar-heading text-center" style="color-background:grey">Pengaturan</h1>'
        +'<ul class="control-sidebar-menu" >'


+'         <li>'
+'<a href="{{ route(\'logout\') }}"  onclick="">'
+'        <h4 class="control-sidebar-subheading">'
+'               Profil'
+'          <i class="menu-icon fa  fa-address-card bg-green pull-right"  aria-hidden="true"></i>'
+'        </h4>'
+'        <div class="progress progress-xxs">'
+'           <div class="progress-bar progress-bar-success" style="width: 100%"></div>'
+'        </div>'
+' </a>'
+'      </li>'

+'         <li>'
+'<a href="{{ route(\'logout\') }}"  onclick="">'
+'        <h4 class="control-sidebar-subheading">'
+'                Ubah Email'
+'          <i class="menu-icon fa  fa-user-secret bg-green pull-right"  aria-hidden="true"></i>'
+'        </h4>'
+'        <div class="progress progress-xxs">'
+'           <div class="progress-bar progress-bar-success" style="width: 100%"></div>'
+'        </div>'
+' </a>'
+'      </li>'

+'         <li>'
+'<a href="{{ route(\'logout\') }}"  onclick="">'
+'        <h4 class="control-sidebar-subheading">'
+'                Ubah Password'
+'          <i class="menu-icon fa  fa-unlock bg-green pull-right"  aria-hidden="true"></i>'
+'        </h4>'
+'        <div class="progress progress-xxs">'
+'           <div class="progress-bar progress-bar-success" style="width: 100%"></div>'
+'        </div>'
+' </a>'
+'      </li>'

+'         <li>'
+'  <a class="dropdown-item" href="{{ route(\'logout\') }}"  onclick="event.preventDefault();'
+'              document.getElementById(\'logout-form\').submit();">'
+'        <h4 class="control-sidebar-subheading">'
+'                Keluar'
+'          <i class="menu-icon fa  fa-sign-out bg-red pull-right"  aria-hidden="true"></i>'
+'        </h4>'
+'        <div class="progress progress-xxs">'
+'           <div class="progress-bar progress-bar-danger" style="width: 100%"></div>'
+'        </div>'
+' </a>'
+'            <form id="logout-form" action="{{ route(\'logout\') }}" method="POST" style="display: none;">'
+'                @csrf'
+'            </form>'
+'      </li>'

        +'</ul>'
        +'</div>'

    );

  $tabPane.append($demoSettings)
  $('#control-sidebar-home-tab').after($tabPane)

  // setup()

  // $('[data-toggle="tooltip"]').tooltip()
})
