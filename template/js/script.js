var oData;
var oTable;
var sImg;
var sUrl;
var frm	= {}; // Form
(function ($) {
    'use strict';

    if (typeof jQuery === "undefined") {
        throw new Error("jQuery plugins need to be before this file");
    }

    $.AdminBSB = {};
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    /* Options =================================================================================================================
    *  You can manage the panel options */
    $.AdminBSB.options = {
        leftSideBar: {
            scrollColor: 'rgba(0,0,0,0.32)',
            scrollWidth: '5px',
            scrollAlwaysVisible: false,
            scrollBorderRadius: '8px',
            scrollRailBorderRadius: '8px'
        },
        rightSideBar: {
            scrollColor: 'rgba(0,0,0,0.32)',
            scrollWidth: '5px',
            scrollAlwaysVisible: false,
            scrollBorderRadius: '8px',
            scrollRailBorderRadius: '8px'
        },
        dropdownMenu: {
            effectIn: 'fadeIn',
            effectOut: 'fadeOut'
        },
        navbar: {
            toggleClass: 'ls-toggled'
        },
        panel: {
            iconClass: {
                close: 'fa fa-close',
                fullscreenOn: 'fa fa-expand',
                fullscreenOff: 'fa fa-compress',
                collapse: 'fa fa-chevron-up',
                expand: 'fa fa-chevron-down'
            },
            tooltip: {
                show: true,
                closeText: 'Close',
                fullscreenOnOffText: 'Toggle Fullscreen',
                collapseExpandText: 'Collapse/Expand',
                closePlacement: 'bottom',
                fullscreenPlacement: 'bottom',
                collapsePlacement: 'bottom'
            },
            controls: {
                collapsable: true,
                fullscreen: true,
                close: true
            }
        }
    }

    /* Panel - Function =======================================================================================================
    *  You can manage the panel options */
    $.AdminBSB.panel = {
        init: function () {
            var $this = this;

            $this.initIcons();
        },
        initIcons: function () {
            var $this = this;
            var configs = $.AdminBSB.options.panel;

            $('.panel')
                .each(function (i, key) {
                    if (!$(key).parent().hasClass('panel-group')) {
                        var dataAttrs = $(key).data();
                        var $panelControls = $('<div>').addClass('panel-controls');
                        if ($(key).find('.panel-controls').length > 0) $panelControls = $(key).find('.panel-controls');


                        //Collapsable Icon
                        if (dataAttrs["panelCollapsable"] != undefined) {
                            if (dataAttrs["panelCollapsable"]) $panelControls.append($this.collapsableIcon());
                        } else {
                            if (configs.controls.collapsable) $panelControls.append($this.collapsableIcon());
                        }

                        //Fullscreen Icon
                        if (dataAttrs["panelFullscreen"] != undefined) {
                            if (dataAttrs["panelFullscreen"]) $panelControls.append($this.fullscreenIcon());
                        } else {
                            if (configs.controls.fullscreen) $panelControls.append($this.fullscreenIcon());
                        }

                        //Close Icon
                        if (dataAttrs["panelClose"] != undefined) {
                            if (dataAttrs["panelClose"]) $panelControls.append($this.closeIcon());
                        } else {
                            if (configs.controls.close) $panelControls.append($this.closeIcon());
                        }

                        //Add to panel heading
                        $($(key).find('.panel-heading')[0]).append($panelControls);
                    }
                });

            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $this.closeEvent();
                $this.collapseEvent();
                $this.fullScreenEvent();
            },120);
        },
        closeIcon: function () {
            var configs = $.AdminBSB.options.panel;
            var $anchor = $('<a>')
                .attr('href', 'javascript:void(0);')
                .addClass('panel-close');

            //Check tooltip active/passive
            if (configs.tooltip.show) {
                $anchor.attr({
                    'data-toggle': 'tooltip',
                    'data-title': configs.tooltip.closeText,
                    'data-placement': configs.tooltip.closePlacement
                });
            }

            var $i = $('<i>').addClass(configs.iconClass.close);
            return $anchor.append($i);
        },
        collapsableIcon: function () {
            var configs = $.AdminBSB.options.panel;
            var $anchor = $('<a>')
                .attr('href', 'javascript:void(0);')
                .addClass('panel-collapsable');

            //Check tooltip active/passive
            if (configs.tooltip.show) {
                $anchor.attr({
                    'data-toggle': 'tooltip',
                    'data-title': configs.tooltip.collapseExpandText,
                    'data-placement': configs.tooltip.collapsePlacement
                });
            }

            var $i = $('<i>').addClass(configs.iconClass.collapse);
            return $anchor.append($i);
        },
        fullscreenIcon: function () {
            var configs = $.AdminBSB.options.panel;
            var $anchor = $('<a>')
                .attr('href', 'javascript:void(0);')
                .addClass('panel-fullscreen');

            //Check tooltip active/passive
            if (configs.tooltip.show) {
                $anchor.attr({
                    'data-toggle': 'tooltip',
                    'data-title': configs.tooltip.fullscreenOnOffText,
                    'data-placement': configs.tooltip.fullscreenPlacement
                });
            }

            var $i = $('<i>').addClass(configs.iconClass.fullscreenOn);
            return $anchor.append($i);
        },
        closeEvent: function () {
            $('.panel')
                .on('click',
                    'a.panel-close',
                    function () {
                        $(this)
                            .parents('.panel')
                            .fadeOut(function () {
                                $(this).remove();
                                $(this).tooltip('hide');
                            });
                    });
        },
        collapseEvent: function () {
            var configs = $.AdminBSB.options.panel;

            $('.panel')
                .on('click',
                    'a.panel-collapsable',
                    function () {
                        var $icon = $(this).find('i');
                        var iconClass = $icon.hasClass(configs.iconClass.collapse)
                            ? configs.iconClass.expand
                            : configs.iconClass.collapse;

                        $icon.removeAttr('class').addClass(iconClass);
                        $icon.parents('.panel').toggleClass('panel-collapsed');
                        $icon.parents('.panel').find('.panel-body').slideToggle();
                        $(this).tooltip('hide');
                    });
        },
        fullScreenEvent: function () {
            var configs = $.AdminBSB.options.panel;

            $('.panel')
                .on('click',
                    'a.panel-fullscreen',
                    function () {
                        var $icon = $(this).find('i');
                        var iconClass = $icon.hasClass(configs.iconClass.fullscreenOn)
                            ? configs.iconClass.fullscreenOff
                            : configs.iconClass.fullscreenOn;

                        $icon.removeAttr('class').addClass(iconClass);
                        $icon.parents('.panel').toggleClass('panel-fullscreen');
                        $(this).tooltip('hide');
                    });
        }
    }

    /* Left Sidebar - Function =================================================================================================
    *  You can manage the left sidebar menu options */
    var windowWidthForLeftSideBar = $(window).width();
    $.AdminBSB.leftSideBar = {
        init: function () {
            var $this = this;
            var $menu = $('.metismenu'), $body = $('body');

            //Init menu
            $menu.metisMenu();

            $this.setMenuWhenFixedAndToggled();

            $(window).bind('load resize', function () {
                $this.setVerticalScrollBar();
                $this.setMenuOnlyFixedSidebar();
                $this.setMenuNonFixed();
                $this.setMenuFixedButNavbarNonFixed();
                $this.changeHiddenStatu();
            });

            $(window).bind('scroll', function () {
                $this.setMenuOnlyFixedSidebar();
                $this.setMenuNonFixed();
                $this.setMenuFixedButNavbarNonFixed();
            });
        },
        fadeEffect: function () {
            var $menu = $('.metismenu');
            $menu.hide();
            setTimeout(function () {
                $menu.fadeIn();
            },
                400);
        },
        setMenuWhenFixedAndToggled: function () {
            var $this = this;
            var $menu = $('.metismenu');
            var $body = $('body');

            if ($this.isFixed() && $this.isToggled()) {
                $menu.hover(function () {
                    //$this.fadeEffect();
                    $body.removeClass('ls-toggled');
                }, function () {
                    //$this.fadeEffect();
                    $body.addClass('ls-toggled');
                });
            } else {
                $menu.unbind('mouseenter mouseleave');
            }
        },
        setSubMenuHeight: function () {
            $('.metismenu')
                .find('li')
                .has('ul')
                .children('a')
                .on('click',
                    function () {
                        var $this = $(this);
                        var heightVal = $(window).height() - $this.offset().top;
                        $this.next()
                            .css({
                                'max-height': heightVal,
                                'overflow-y': 'hidden'
                            });
                        setTimeout(function () { $this.next().css('overflow-y', 'auto') }, 400);
                    });
        },
        setVerticalScrollBar: function () {
            var $this = this;

            if ($this.isFixed()) {
                var $menu = $('.metismenu');
                var height = $.AdminBSB.navbar.isFixed() ? $(window).height() - $('.navbar').height() : $(window).height();

                $menu.slimScroll({ destroy: true }).height('auto');
                $menu.parent().find('.slimScrollBar, .slimScrollRail').remove();

                var configs = $.AdminBSB.options.leftSideBar;
                $menu.slimscroll({
                    height: height + "px",
                    color: configs.scrollColor,
                    size: configs.scrollWidth,
                    alwaysVisible: configs.scrollAlwaysVisible,
                    borderRadius: configs.scrollBorderRadius,
                    railBorderRadius: configs.scrollRailBorderRadius
                });
            }
        },
        isFixed: function () {
            return $('body').hasClass('ls-fixed');
        },
        isToggled: function () {
            return $('body').hasClass('ls-toggled');
        },
        setVerticalScrollbar: function () {
            var $menu = $('.metismenu');
            if (typeof $.fn.slimScroll != 'undefined' && $('body').hasClass('fixed-sidebar')) {
                var $body = $('body');
                var height;

                if ($body.hasClass('fixed-sidebar') && !$body.hasClass('fixed-navbar')) {
                    height = $(window).height();
                } else if ($body.hasClass('navbar-fixed')) {
                    height = $(window).height() - $('.navbar').height();
                } else {
                    $menu.slimScroll({ destroy: true });
                    return;
                }

                var configs = $.AdminBSB.options.leftSideBar;

                $menu.slimScroll({ destroy: true }).height('auto');
                $menu.parent().find('.slimScrollBar, .slimScrollRail').remove();

                $menu.slimscroll({
                    height: height + "px",
                    color: configs.scrollColor,
                    size: configs.scrollWidth,
                    alwaysVisible: configs.scrollAlwaysVisible,
                    borderRadius: configs.scrollBorderRadius,
                    railBorderRadius: configs.scrollRailBorderRadius
                });
            } else {
                $menu.slimScroll({ destroy: true });
            }
        },
        setMenuOnlyFixedSidebar: function () {
            var $body = $('body');
            if ($body.hasClass('fixed-sidebar') && !$body.hasClass('fixed-navbar')) {
                var paddingTop = 50 - $(window).scrollTop();
                paddingTop = paddingTop < 0 ? 0 : paddingTop;
                $('.sidebar').css('padding-top', paddingTop);
            }
        },
        setMenuNonFixed: function () {
            var $this = this;

            $this.setSidebarHeight();

            $('.metismenu')
                .on('click',
                    '.collapse.in li a',
                    function (e) {
                        e.stopPropagation();
                    });
        },
        setSidebarHeight: function () {
            var $sidebar = $('.sidebar');
            var $content = $('.content');
            var $doc = $(document);

            var sidebarHeight = $sidebar.find('.sidebar-nav').height();
            var contentHeight = $content.height();
            var docHeight = $doc.height() - $('.navbar').height();
            var sidebarNewHeight = Math.max(sidebarHeight, contentHeight, docHeight) + ($sidebar.innerHeight() - $sidebar.height());
            $sidebar.css('height', sidebarNewHeight);

            $content.each(function (i, key) {
                if ($(key).parents('.wizard').length === 0) { $(key).css('min-height', sidebarHeight); }
            });
        },
        setMenuFixedButNavbarNonFixed: function () {
            var $this = this;
            var $sidebar = $('.sidebar');

            if ($this.isFixed() && !$.AdminBSB.navbar.isFixed()) {
                var scrollTop = $(window).scrollTop();
                var top = 50 - scrollTop < 0 ? 0 : (scrollTop > 50 ? scrollTop : 50 - scrollTop);

                $sidebar.css('top', top);
            }
        },
        changeHiddenStatu: function () {
            var width = $(window).width();

            var $body = $('body');

            if (width < 767) {
                $body.addClass('ls-hidden');
            } else {
                $body.removeClass('ls-hidden');
            }
        }
    }

    /* Right Sidebar - Function ================================================================================================
    *  You can manage the right sidebar menu options */
    $.AdminBSB.rightSideBar = {
        init: function () {
            var $this = this;
            var $sidebar = $('.right-sidebar');
            var $closeBtn = $('.right-sidebar-close');
            var $openSidebarBtn = $('.js-right-sidebar');

            $openSidebarBtn.on('click', function () {
                $sidebar.addClass('open');
            });

            $closeBtn.on('click', function () {
                $sidebar.removeClass('open');
            });

            $this.setVerticalScroll();
            $(window).resize($this.setVerticalScroll);
        },
        setVerticalScroll: function () {
            var $contentAreas = $('.right-sidebar .tab-container');

            var configs = $.AdminBSB.options.rightSideBar;
            var height = $(window).height() - ($('.right-sidebar .nav-tabs').height());

            $contentAreas.slimscroll({
                height: height + "px",
                color: configs.scrollColor,
                size: configs.scrollWidth,
                alwaysVisible: configs.scrollAlwaysVisible,
                borderRadius: configs.scrollBorderRadius,
                railBorderRadius: configs.scrollRailBorderRadius
            });
        }
    }
    //==========================================================================================================================

    /* Navbar - Function =======================================================================================================
    *  You can manage the navbar options */
    $.AdminBSB.navbar = {
        init: function () {
            var $this = this;
            var $navbarToggle = $('.js-toggle-left-sidebar');
            var $leftNavbarToggle = $('.js-left-toggle-left-sidebar');
            var $body = $('body');
            var $navbarMenu = $('.dropdown .body .menu');
            var $searchBar = $('.search-bar');

            $navbarToggle.on('click',
                function () {
                    $body.toggleClass($.AdminBSB.options.navbar.toggleClass);
                    $.AdminBSB.leftSideBar.fadeEffect();
                    $.AdminBSB.leftSideBar.setMenuWhenFixedAndToggled();
                });

            $leftNavbarToggle.on('click',
                function () {
                    $body.toggleClass('ls-hidden');
                });

            $navbarMenu.slimscroll({
                height: 255,
                color: 'rgba(0,0,0,0.5)',
                size: '4px',
                alwaysVisible: false,
                borderRadius: '0',
                railBorderRadius: '0'
            });

            //Open search bar
            $('.js-search').on('click', function () {
                $searchBar.addClass('open');
                $searchBar.find('input[type="text"]').focus();
            });

            //Close search bar
            $('.js-close-search').on('click', function () {
                $searchBar.removeClass('open');
            });

            $this.fullScreen();
        },
        isFixed: function () {
            return $('body').hasClass('navbar-fixed');
        },
        fullScreen: function () {
            var $fullScreen = $('.js-fullscreen');
            var $icon = $fullScreen.find('.material-icons');

            if (screenfull.enabled) {
                $fullScreen.on('click', function () {
                    if (screenfull.isFullscreen) { screenfull.exit(); } else { screenfull.request(); }
                });

                $(document).on(screenfull.raw.fullscreenchange, function () {
                    if (screenfull.isFullscreen) { $icon.text('fullscreen_exit'); } else { $icon.text('fullscreen'); }
                });
            }
        }
    }


    /* Browser - Function ======================================================================================================
    *  You can manage browser
    *  
    */
    var edge = 'Microsoft Edge';
    var ie10 = 'Internet Explorer 10';
    var ie11 = 'Internet Explorer 11';
    var opera = 'Opera';
    var firefox = 'Mozilla Firefox';
    var chrome = 'Google Chrome';
    var safari = 'Safari';

    $.AdminBSB.browser = {
        init: function () {
            var _this = this;
            var className = _this.getClassName();

            if (className !== '') $('html').addClass(_this.getClassName());
        },
        getBrowser: function () {
            var userAgent = navigator.userAgent.toLowerCase();

            if (/edge/i.test(userAgent)) {
                return edge;
            } else if (/rv:11/i.test(userAgent)) {
                return ie11;
            } else if (/msie 10/i.test(userAgent)) {
                return ie10;
            } else if (/opr/i.test(userAgent)) {
                return opera;
            } else if (/chrome/i.test(userAgent)) {
                return chrome;
            } else if (/firefox/i.test(userAgent)) {
                return firefox;
            } else if (!!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)) {
                return safari;
            }

            return undefined;
        },
        getClassName: function () {
            var browser = this.getBrowser();

            if (browser === edge) {
                return 'edge';
            } else if (browser === ie11) {
                return 'ie11';
            } else if (browser === ie10) {
                return 'ie10';
            } else if (browser === opera) {
                return 'opera';
            } else if (browser === chrome) {
                return 'chrome';
            } else if (browser === firefox) {
                return 'firefox';
            } else if (browser === safari) {
                return 'safari';
            } else {
                return '';
            }
        }
    }
    //==========================================================================================================================


    /* DropdownMenu - Function =================================================================================================
    *  You can manage the dropdown menu */

    $.AdminBSB.dropdownMenu = {
        init: function () {
            var $this = this;

            $('.dropdown, .dropup, .btn-group').on({
                "show.bs.dropdown": function () {
                    var dropdown = $this.dropdownEffect(this);
                    $this.dropdownEffectStart(dropdown, dropdown.effectIn);
                },
                "shown.bs.dropdown": function () {
                    var dropdown = $this.dropdownEffect(this);
                    if (dropdown.effectIn && dropdown.effectOut) {
                        $this.dropdownEffectEnd(dropdown, function () { });
                    }
                },
                "hide.bs.dropdown": function (e) {
                    var dropdown = $this.dropdownEffect(this);
                    if (dropdown.effectOut) {
                        e.preventDefault();
                        $this.dropdownEffectStart(dropdown, dropdown.effectOut);
                        $this.dropdownEffectEnd(dropdown, function () {
                            dropdown.dropdown.removeClass('open');
                        });
                    }
                }
            });
        },
        dropdownEffect: function (target) {
            var effectIn = $.AdminBSB.options.dropdownMenu.effectIn, effectOut = $.AdminBSB.options.dropdownMenu.effectOut;
            var dropdown = $(target), dropdownMenu = $('.dropdown-menu', target);

            if (dropdown.length > 0) {
                var udEffectIn = dropdown.data('effect-in');
                var udEffectOut = dropdown.data('effect-out');
                if (udEffectIn !== undefined) { effectIn = udEffectIn; }
                if (udEffectOut !== undefined) { effectOut = udEffectOut; }
            }

            return {
                target: target,
                dropdown: dropdown,
                dropdownMenu: dropdownMenu,
                effectIn: effectIn,
                effectOut: effectOut
            };
        },
        dropdownEffectStart: function (data, effectToStart) {
            if (effectToStart) {
                data.dropdown.addClass('dropdown-animating');
                data.dropdownMenu.addClass('animated dropdown-animated');
                data.dropdownMenu.addClass(effectToStart);
            }
        },
        dropdownEffectEnd: function (data, callback) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            data.dropdown.one(animationEnd, function () {
                data.dropdown.removeClass('dropdown-animating');
                data.dropdownMenu.removeClass('animated dropdown-animated');
                data.dropdownMenu.removeClass(data.effectIn);
                data.dropdownMenu.removeClass(data.effectOut);

                if (typeof callback == 'function') {
                    callback();
                }
            });
        }
    }
	
    /* Custom - Function =======================================================================================================
    *===========================================================================================================================*/
	$.AdminBSB.Custom = {
        init: function () {
			$.AdminBSB.Custom.uploader();
			$.AdminBSB.Custom.iCheck();
			
			//Masked Input
			$('[data-inputmask]').inputmask();

			$('.content').on('click','.href',function () {
				if( $(this).data('href') !== undefined ){
					location.href = $(this).data('href');
				}else{
					$.AdminBSB.Custom.toastr('warning', 'ไม่พบที่อยู่ปลายทาง');
				}
			});
			
			$('.content').on('click','.cBack',function (e) {
				e.preventDefault();
				window.history.back();
			});
			
			$('.content').on('click','.cDelete',function () {
				if( $(this).attr('rel') !== undefined ){
					if(confirm('Are you sure?') == true){
						$.AdminBSB.Custom.toastr('info', 'กำลังเริ่มทำรายการ');
						$.ajax({
							url: $(this).attr('rel'),
							type: 'DELETE',
							dataType: "JSON",
							success: function(result) {
								$.AdminBSB.Custom.toastr(result.status.toLowerCase(),result.msg);
								oTable.dataTable()._fnAjaxUpdate();
							}
						});
					}else{
						$.AdminBSB.Custom.toastr('info', 'ยกเลิกการทำรายการ');
					}
				}else{
					$.AdminBSB.Custom.toastr('warning', 'ไม่พบที่อยู่ปลายทาง');
				}
			});
			
			$('.content').on('click','.cAjax',function () {
				if( $(this).attr('rel') !== undefined && $(this).attr('rel')!='' ){
					var msg = $(this).data('alert')?$(this).attr('alert'):'ยืนยันการทำรายการ?';
					if( confirm(msg) == true ){
						$.AdminBSB.Custom.toastr('info', 'กำลังเริ่มทำรายการ');
						$.ajax({
							url: $(this).attr('rel'),
							type: 'POST',
							dataType: "JSON",
							success: function(response) {
								$.AdminBSB.Custom.toastr(response.status.toLowerCase(),response.msg);
								if(response.mode=='reload'){
									setTimeout(function () {
										location.reload(true);
									},3000);
								}
								if(response.mode=='dataTable'){
									oTable.dataTable()._fnAjaxUpdate();
								}
							}
						});
					}else{
						$.AdminBSB.Custom.toastr('info', 'ยกเลิกการทำรายการ');
					}
				}else{
					$.AdminBSB.Custom.toastr('warning', 'ไม่พบที่อยู่ปลายทาง');
				}
			});
			
			if( $('#toastr-alert').length ){
				var key = $('#toastr-alert').attr('rel');
				if(key=='danger') key='error';
				$.AdminBSB.Custom.toastr(key, $('#toastr-alert').html());
			}
        },
        toastr: function(type, msg1, msg2) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "4000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr[type](msg1,msg2);
			return 'toastr : '+msg1;
		},
        iCheck: function(){
			if( $('input[data-icheck-theme]').length ){
				$('head').append($("<link rel='stylesheet' href='themes/adminbsb/assets/plugins/iCheck/skins/all.css' type='text/css' media='screen' />"));

				$.getScript( 'themes/adminbsb/assets/plugins/iCheck/icheck.min.js', function( data, textStatus, jqxhr ) {
					$('input[data-icheck-theme]').each(function (i, key) {
						var color = $(key).data('icheckColor');
						var theme = $(key).data('icheckTheme');
						var baseCheckboxClass = 'icheckbox_' + theme;
						var baseRadioClass = 'iradio_' + theme;

						$(key).iCheck({
							checkboxClass: color === theme ? baseCheckboxClass : baseCheckboxClass + '-' + color,
							radioClass: color === theme ? baseRadioClass : baseRadioClass + '-' + color
						});
					});
				});
			}
		},
        uploader: function() {
			var sMain = $('.Uploader');
			if( $('.ImgUploader').length ){
				$('.content').on('click','.ImgUploader',function () {
					sImg = $(this);
					sUrl = (sImg.data('url') !== undefined?sImg.data('url'):sMain.data('url') );
					if( $('#Uploader').length < 1 && sMain.attr('disabled') != 'disabled'){
						$( 'body' ).append( '<div id="Uploader"><form method="post" enctype="multipart/form-data" action=""><input type="file" style="display:none" accept="image/*" /></form></div>' );
						$('body').on('change','#Uploader input',function(e){
							var file = e.target.files[0];
							if( file !== undefined ){
								if(file.size > 5242880){//default 5 MB
									$.AdminBSB.Custom.toastr('error', 'File size Not Allowed!', 'Error');
									return;
								}
								var sData = new FormData();
								sData.append('file',file);
								if(sImg) $.each(sImg.data(),function(i,v){sData.append(i, v);});
								if(sMain) $.each(sMain.data(),function(i,v){sData.append(i, v);});
								$('#Uploader input').val('');
								$.ajax({
									url:sUrl,
									type: 'POST',
									data: sData,
									processData: false,
									contentType: false,
									enctype: 'multipart/form-data',
									beforeSend : function (){
										sImg.parent().waitMe({bg: 'rgba(255,255,255,0.90)'});
										$.AdminBSB.Custom.toastr('info', 'Start Uploading..');
									},
									success:function(response){
										sImg.parent().waitMe('hide');
										sImg.attr('src',response.src);
										sImg.data(response);
										$.AdminBSB.Custom.toastr('success', 'Upload Complete!');
									},
									error:function(xhr,textStatus,errorThrown){
										sImg.parent().waitMe('hide');
										$.AdminBSB.Custom.toastr('error', errorThrown, textStatus.toUpperCase());
									}
								});
							}
						});
					}
					if( sImg.data('id')==undefined || sImg.data('id')=='' ){
						$('#Uploader input').trigger('click');
					}else{
						$('#imgbox p').attr('rel',sUrl+'/'+sImg.data('id'));
						$('#imgbox img').attr('src',sImg.attr('src').replace('_thumb', ''));
						$('#imgbox').fadeIn();
					}
				});	
				
				$( '.content' )
				.append('<div id="imgbox"><p class="cDelete">Click to Delete</p><div id="content"><img src="#" /></div></div>')
				.on('click','#imgbox #content',function () {	
					$('#imgbox').fadeOut( 'slow', function() {
						$('#imgbox p').attr('rel','');
						$('#imgbox img').attr('src','');
					});
				}).on('click','#imgbox p',function (e) {	
					
				});	
				if( sMain.attr('disabled') == 'disabled' ){
					$('#imgbox p').hide();
				}
			}
		},
        DeleteImage: function(result) {
			
		},
        DataTable: function(options) {
			var defaults = {
				order:false,
				processing:true,
				serverSide:true,
				scroller:true,
				scrollCollapse:true,
				stateSave:true,
				iDisplayLength:true,
				sDom:"<'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>"
			};
			var s = $.extend( {}, defaults, options );
			oTable = $('#DataTable').DataTable({
				sDom: s.sDom,
				order: s.order,
				processing: s.processing,
				serverSide: s.serverSide,
				scroller: s.scroller,
				scrollCollapse: s.scrollCollapse,
				stateSave: s.stateSave,
				scrollY: ''+($(window).height()-370)+'px',
				iDisplayLength: 10,
				ajax: {
					url: s.url,
					data: function ( d ) {  
						d.Where={};
						$('#btn-Excel').css("display", "none");
						$('.myWhere').each(function() {
							if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
								d.Where[$(this).attr('name')] = $.trim($(this).val());
								$('#btn-Excel').css("display", "initial");
							}
						});
						d.Like={};
						$('.myLike').each(function() {
							if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
								d.Like[$(this).attr('name')] = $.trim($(this).val());
								$('#btn-Excel').css("display", "initial");
							}
						});
						d.Custom={};
						$('.myCustom').each(function() {
							if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
								d.Custom[$(this).attr('name')] = $.trim($(this).val());
								$('#btn-Excel').css("display", "initial");
							}
						});
						oData = d;
						d.onlyTrashed=$('#onlyTrashed').is(':checked');
						$('.dataTables_scrollBody').waitMe({bg: 'rgba(255,255,255,0.90)'});
					},
					method: 'POST'
				},
				columns: s.columns,
				rowCallback: s.rowCallback,
				drawCallback: function( settings ) {
					$('.dataTables_scrollBody').waitMe('hide');
				}
			});
			if( $('.dataTables_scrollBody').length ){
				$('.myWhere,.myLike,#onlyTrashed').on('change', function(e){
					oTable.draw();
				});
			}
		},
    }
	


	frm.LoadForm=function(selector){
		var form = {};
		var a = {};
		$('.'+selector).each(function(){
			var self = $(this);
			var name = self.attr('name');

			if( name.substr(-2) == '[]' ){
				var n = name.replace('[]', '');
				if(isNaN(a[n])){a[n]= 0;}else{a[n]++;}
				name = n+'['+a[n]+']';
			}

			if(self.is('input:text')){
				if( self.is(".price") || self.is(".num") ){
					form[name] = frm.Trim(self.val().replace(/,/g, ''));
				}else{
					form[name] = frm.Trim(self.val());
				}
			}else if(self.is('textarea')){
				form[name] = frm.Trim(self.val());
			}else if(self.is('input:checkbox')){
				if(self.is(':checked')){
					if(form[name]){
						if(jQuery.isArray(form[name]) == false){
							inum = 1;
							form[name] = [form[name]];
							form[name][inum++] = self.val();
						}else{
							form[name][inum++] = self.val();
						}
					}else{
						form[name] = $('input[name="'+name+'"]:checked').val();
					}
				}
			}else if(self.is('input:radio')){
				form[name] = frm.GetRadio(name);
			}else{
				form[name] = self.val();
			}
		});
        console.log(form);
		return form;
	}
	
    frm.GetRadio=function(name){
        return $('input[name="'+name+'"]:checked').val();
    }
	frm.PutFormOption=function(aData){
		
	}
		
	frm.PutForm=function(selector, aData){
		frm.PutFormOption(aData);
		$('.'+selector).each(function(){
			var name = $(this).attr('name');
			if( aData[name] ){
				if( $(this).is('.price3') ){
					aData[name] = frm.FormatPrice(aData[name],3);
				}
                
				
                if( $(this).is('[type="radio"]') ){
                    if( $(this).is('[type="radio"][value="'+aData[name]+'"]') ){
                       console.log($(this).attr('value'))
                        $(this).iCheck('check');
                    }
                }
                else{
                    $(this).val(aData[name]);
                }
			}
		});
	}
	
	frm.LTrim=function(str){
		if (str==null){
			return null;
		}
		for(var i=0; str.charAt(i)==" "; i++);
		return str.substring(i,str.length);
	}

	frm.RTrim=function(str){
		if (str==null){
			return null;
		}
		for(var i=str.length-1;str.charAt(i)==" ";i--);
		return str.substring(0,i+1);
	}

	frm.Trim=function(str){
		return frm.LTrim(frm.RTrim(str));
	}

	frm.AddCommas=function(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
	frm.FormatPrice=function(numset, decimal=2){
		if(!numset) return '0';
		var num = parseFloat(numset.replace(/,/g,''));
		if(isNaN(num)){
			return '0';
		}else{
			return frm.AddCommas(num.toFixed(decimal));
		}
	}

	frm.FormatNum=function(numset){
		if(!numset) return '0';
		var num = parseFloat(numset.replace(/,/g,''));
		if(isNaN(num)){
			return '0';
		}else{
			return frm.AddCommas(num);
		}
	}

	$('input').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});
	
		
    //==========================================================================================================================

    /* Page Load - Function ====================================================================================================
    *  You can manage the function when page loaded */
 
}(jQuery));