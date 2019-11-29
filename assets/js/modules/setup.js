var $ = jQuery.noConflict();
//console.log(theme_backend_script_object);
// button-plugin-install
export default function() {
    if($('#admin-theme__setup').length <= 0) return;

    var _store = {
        state: {
            DisablePluginCompatibleUi: false,
        },
        Set_DisablePluginCompatibleUi(value) {
            this.state.DisablePluginCompatibleUi = value;
        }
    }

    var _components = {
        ThemeExtendsButtonPluginInstall: {
            props: ['plugin'],
            template: `<div class="button-plugin-install-element">
                <a class="ajax-loading-area" v-if="is_request == true"><span class="__icon"><i class="el-icon-loading"></i></span></a>
                <div v-if="button_type != ''">
                    <a v-if="button_type == 'not_installed'" href="#" class="__btn btn-install" @click="InstallActivePlugin(PluginData, $event)">+ Install & Active Now</a>
                    <a v-if="button_type == 'is_installed'" href="#" class="__btn btn-active" @click="ActivePlugin(PluginData, $event)">+ Active Now</a>
                    <a v-if="button_type == 'is_locked'" href="#" class="__btn btn-install" @click="UnlockPlugin(PluginData, $event)">+ Activate license</a>
                    <a v-if="button_type == 'is_activated'" href="#" class="__btn btn-activated">Activated</a>
                </div>
                <div v-else>
                    <a v-show="!is_request" href="#" class="__btn btn-active" @click="GetNow(PluginData, $event)">Get Now</a>
                </div>
            </div>`,
            data() {
                return {
                    is_request: false,
                    button_type: '',
                };
            },
            created(el) {
                // this.GetButtonType();
            },
            computed: {
                PluginData() {
                    return JSON.parse(this.plugin);
                }
            },
            methods: {
                GetNow(data, evt) {
                    var self = this;
                    evt.preventDefault();
                    this.GetButtonType();
                },
                GetButtonType() {
                    var self = this;
                    this.is_request = true;

                    $.ajax({
                        type: 'POST',
                        url: theme_backend_script_object.ajax_url,
                        data: { action: 'jayla_ajax_get_plugin_install_type', plugin: self.PluginData },
                        success(res) {
                            self.is_request = false;
                            if( res.success == true ) {
                                self.button_type = res.data.type;
                            } else {
                                // false
                            }

                        },
                        error(e) {
                            console.log(e);
                        }
                    })
                },
                InstallActivePlugin(data, evt) {
                    var self = this;
                    evt.preventDefault();

                    // disable ui plugin
                    _store.Set_DisablePluginCompatibleUi(true);

                    $.ajax({
                        type: 'POST',
                        url: theme_backend_script_object.ajax_url,
                        data: {action: 'jayla_ajax_install_plugin_handle', data: data},
                        success(res) {
                            // enable ui plugin
                            _store.Set_DisablePluginCompatibleUi(false);
                            console.log(res);
                            if(res.success == true) {
                                // true
                                self.$notify.success({ title: 'Install Success', message: data.name, offset: 100 });
                                self.button_type = 'is_installed';

                                self.ActivePlugin(data, evt);
                            } else {
                                // false
                                self.$notify.error({ title: 'Install Error', message: data.name, offset: 100 });
                            }
                        },
                        error(e) {
                            self.$notify.error({ title: 'Install Error', message: JSON.stringify(e), offset: 100 });
                        }
                    })
                },
                ActivePlugin(data, evt) {
                    var self = this;
                    evt.preventDefault();

                    // disable ui plugin
                    _store.Set_DisablePluginCompatibleUi(true);

                    $.ajax({
                        type: 'POST',
                        url: theme_backend_script_object.ajax_url,
                        data: {action: 'jayla_ajax_active_plugin_handle', data: data},
                        success(res) {
                            // enable ui plugin
                            _store.Set_DisablePluginCompatibleUi(false);

                            if(res.success == true) {
                                // true
                                self.$notify.success({ title: 'Active Success', message: data.name, offset: 100 });
                                self.button_type = 'is_activated';
                            } else {
                                // false
                                self.$notify.error({ title: 'Active Error', message: data.name, offset: 100 });
                            }
                        },
                        error(e) {
                            self.$notify.error({ title: 'Active Error', message: JSON.stringify(e), offset: 100 });
                        }
                    })
                },
                UnlockPlugin(data, evt) {
                    evt.preventDefault();
                    this.$root.$emit( 'change_active_tab', 'requirements' );
                }
            }
        },
        ModalInstallDemoInstallLog: {
            props: ['steps', 'MessageLog', 'ActiveStep'],
            template: `<div>
                <div class="install-message-container" ref="messageLogContainer">
                    <ul>
                        <li v-for="message in MessageLogData"><div v-html="message"></div></li>
                    </ul>
                </div>
                <div class="install-steps-container">
                    <el-steps :space="85" direction="vertical" :active="IsActiveStep" finish-status="success">
                        <el-step v-for="(step, index) in steps" :description="step.description" :key="step.name">
                            <template slot="title"><i v-show="index == IsActiveStep" class="el-icon-loading"></i> {{ step.title }}</template>
                        </el-step>
                    </el-steps>
                </div>
            </div>`,
            data() {
                return {

                };
            },
            watch: {
                MessageLogData(data) {
                    var self = this;
                    setTimeout(function() {
                        $(self.$refs.messageLogContainer).stop(true, true).animate({
                            scrollTop: $(self.$refs.messageLogContainer).children().innerHeight(),
                        }, 300)
                    }, 100)

                }
            },
            computed: {
                IsActiveStep() {
                    return (this.ActiveStep) ? this.ActiveStep : 0;
                },
                MessageLogData() {
                    return this.MessageLog;
                }
            }
        },
        ModalInstallDemo: {
            props: ['packageData', 'isInstall'],
            template: `<div class="__modal-install-wraper">
                <div v-show="!_IsInstall" class="__modal-inner">
                    <slot></slot>
                </div>

                <div v-show="_IsInstall" class="__modal-install-log">
                    <slot name="install-log"></slot>
                </div>
            </div>`,
            data() {
                return {

                };
            },
            computed: {
                _IsInstall() {
                    return (this.isInstall) ? this.isInstall : false;
                }
            }
        },
    };

    new Vue({
        el: '#admin-theme__setup',
        components: _components,
        data() {
            return {
                ThemeSetupActiveTab: 'requirements',
                ThemeAdvancedOptions: {},
                LoadThemeAdvancedOptionsComplete: false,
                ThemeAdvancedOptionsIsLoading: true,
                ShareStore: _store.state,
                InstallPackageDemo: {
                    stepInstallList: [
                        {
                            name: 'backup_site',
                            title: 'Backup Site',
                            description: 'Backup content & media',
                        },
                        {
                            name: 'install_plugin_include',
                            title: 'Install Plugin Include',
                            description: 'Install & active plugin required for package',
                        },
                        {
                            name: 'download_package_demo',
                            title: 'Download Package',
                            description: 'Download package from our server',
                        },
                        {
                            name: 'extract_package_demo',
                            title: 'Extract Package',
                            description: 'Extract package on your upload folder',
                        },
                        {
                            name: 'import_package_demo',
                            title: 'Import Content Demo',
                            description: 'Import content data & finish.',
                        },
                    ],
                    stepInstallActive: 0,
                    isInstall: false,
                    installMessageLog: ['Installing package demo...'],
                    itemInstallSelected: {},
                },

            }
        },
        mounted( el ) {
            var self = this;

            // Listen for a custom event
            this.$root.$on('change_active_tab', function( tab_name ) {
                self.ThemeSetupActiveTab = tab_name;
            })
            
            this.LoadThemeAdvancedOptions();
        },
        watch: {
            ThemeAdvancedOptions: {
                handler ( data ) {
                    // console.log( data );
                    if( this.LoadThemeAdvancedOptionsComplete == false )  {
                        this.LoadThemeAdvancedOptionsComplete = true;
                        this.ThemeAdvancedOptionsIsLoading = false;
                        return;
                    };

                    this.SaveThemeAdvancedOptions( data );
                },
                deep: true
            }
        },
        computed: {
            ModalInstallDisplay() {
                return Object.keys(this.InstallPackageDemo.itemInstallSelected).length;
            },
            PackageDemoSelected() {
                return this.InstallPackageDemo.itemInstallSelected;
            },
            stepInstallListName() {
                return this.InstallPackageDemo.stepInstallList.map(function(item) {
                    return item.name;
                });
            },
            ClassesWrapAdvancedOptions () {
                var classes = ['__inner'];
                if( true == this.ThemeAdvancedOptionsIsLoading ) {
                    classes.push( '__is-loading' );
                }

                return classes.join( ' ' );
            }
        },
        methods: {
            SaveThemeAdvancedOptions( data ) {
                var self = this;

                self.ThemeAdvancedOptionsIsLoading = true;
                self.$notify({
                    title: 'Saving...',
                    message: 'Please wait a moment !',
                    offset: 50
                });

                $.ajax({
                    type: 'POST',
                    url: theme_backend_script_object.ajax_url,
                    data: { action: 'jayla_update_theme_advanced_options_ajax', theme_advanced_options: data },
                    success ( res ) {
                        self.ThemeAdvancedOptionsIsLoading = false;
                        if( true == res ) {
                            self.$notify({
                                title: 'Success',
                                message: 'Saved options successful!',
                                type: 'success',
                                offset: 50
                            });

                            return;
                        }

                        self.$notify.error({
                            title: 'Error',
                            message: 'Saved options error please try again!',
                            offset: 50
                        });
                    },
                    error ( err ) {
                        console.log( err );

                        self.ThemeAdvancedOptionsIsLoading = false;
                        self.$notify.error({
                            title: 'Error',
                            message: 'Saved options error please try again!',
                            offset: 50
                        });
                    }
                })
            },
            LoadThemeAdvancedOptions() {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: theme_backend_script_object.ajax_url,
                    data: { action: 'jayla_load_theme_advanced_options_ajax' },
                    success ( res ) {
                        // self.ThemeAdvancedOptions = res;
                        Vue.set( self, 'ThemeAdvancedOptions', res );
                    },
                    error ( err ) {
                        console.log( err );
                    }
                })
            },
            OnOpenModalInstall(even, data) {
                even.preventDefault();
                Vue.set(this.InstallPackageDemo, 'itemInstallSelected', data);
            },
            OnOpenModalLocked(even, data) {
                even.preventDefault();
                this.$root.$emit( 'change_active_tab', 'requirements' );
            },
            OnCloseModalInstall(even) {
                even.preventDefault();
                Vue.set(this.InstallPackageDemo, 'itemInstallSelected', {});
            },
            OnInstallPackage(even, package_data) {
                even.preventDefault();
                this.InstallPackageDemo.isInstall = true;
                this.DoInstallPackage(package_data, 0);
            },
            OnRedirectToFrontend() {
                window.location.href = theme_backend_script_object.site_url;
            },
            DoInstallPackage(package_data, _is_step, _extra_params) {
                var self = this;

                /**
                 * Action step
                 * 1 - backup_site
                 * 2 - install_plugin_include
                 * 3 - download_package_demo (.zip)
                 * 4 - extract_package_demo (extract & delete .zip)
                 * 5 - import_package_demo (Import, Delete folder package & redirect fontend page) */
                var step_list = this.stepInstallListName;
                var is_step = _is_step;
                // var on_action = on_action ? on_action : 'backup_site';

                var send_data = {
                    action: 'jayla_ajax_install_demo_content',
                    package_data: package_data,
                    on_action: step_list[is_step]
                };

                if( _extra_params ) {
                    send_data.extra_params = _extra_params;
                }

                $.ajax({
                    type: 'POST',
                    url: theme_backend_script_object.ajax_url,
                    data: send_data,
                    success(res) {
                        console.log(res);
                        if(res.success) {
                            var res_data = res.data;

                            if( res_data && res_data.message ) {
                                self.InstallPackageDemo.installMessageLog.push(res_data.message);
                            }

                            if(res_data.on_action.status == true) {
                                // step complete
                                var nextStep = is_step += 1;
                                Vue.set(self.InstallPackageDemo, 'stepInstallActive', nextStep);
                                if(step_list[nextStep]) {
                                    self.DoInstallPackage(package_data, nextStep, (res_data.extra_params) ? res_data.extra_params : {});
                                } else {
                                    // finally - redirect to frontend
                                    setTimeout(function() {
                                        self.OnRedirectToFrontend();
                                    }, 300)
                                }
                            } else {
                                // step fail & continue
                                self.DoInstallPackage(package_data, is_step, (res_data.extra_params) ? res_data.extra_params : {});
                            }
                        } else if( res.success == false ) {

                        } else {
                            self.DoInstallPackage(package_data, is_step, {});
                        }
                    },
                    error(e) {

                    },
                })
            }
        }
    })
}
