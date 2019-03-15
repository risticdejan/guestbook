<template>
    <v-app id="inspire" dark>
        <app-sidebar :drawer="drawer" @toggleSidebar="drawer = !drawer"/>

        <app-header @toggleSidebar="drawer = !drawer"/>

        <v-content>
            <v-layout row wrap>
                <v-flex xs12>
                    <router-view></router-view>
                </v-flex>
            </v-layout>
        </v-content>

        <app-footer :ftItems="icons"/>

        <app-loading />
    </v-app>
</template>

<script>
    import AppHeader from "./components/layouts/AppHeader";
    import AppSidebar from "./components/layouts/AppSidebar";
    import AppFooter from "./components/layouts/AppFooter";
    import AppLoading from "./components/layouts/AppLoading.vue";

    export default {
        name: "App",
        components: {
            AppHeader,
            AppSidebar,
            AppFooter,
            AppLoading
        },
        data() {
            return {
                drawer: false,
                icons: [
                    "fab fa-facebook-f",
                    "fab fa-twitter",
                    "fab fa-google-plus-g",
                    "fab fa-linkedin-in",
                    "fab fa-instagram"
                ]
            };
        },
        beforeCreate() {
            this.$store.commit("layout/setRefresh", true);
        }
    };
</script>

<style scope>
    .v-dialog--fullscreen {
        background: #171616;
    }
</style>