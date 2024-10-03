<template>
  <nav
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"
  >
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="shrink-0 flex items-center">
            <Link :href="route('welcome')">
              <ApplicationMark class="block h-9 w-auto" />
            </Link>
          </div>

          <!-- Navigation Links -->
          <div
            class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
            v-if="$page.props.auth.user"
          >
            <NavLink
              :href="route('dashboard')"
              :active="route().current('dashboard')"
            >
              Dashboard
            </NavLink>
            <NavLink
              :href="route('manager')"
              :active="route().current('manager')"
              v-if="$page.props['is-manager']"
            >
              Manager
            </NavLink>
            <NavLink
              :href="route('admin')"
              :active="route().current('admin')"
              v-if="$page.props['is-admin']"
            >
              Admin
            </NavLink>
          </div>
          <div v-else class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <NavLink :href="route('login')" :active="route().current('login')"
              >Login</NavLink
            >
            <NavLink
              :href="route('register')"
              :active="route().current('register')"
              >Signup</NavLink
            >
          </div>
        </div>

        <div
          class="hidden sm:flex sm:items-center sm:ms-6"
          v-if="$page.props.auth.user"
        >
          <div class="ms-3 relative">
            <!-- Teams Dropdown -->
            <Dropdown
              v-if="$page.props.jetstream.hasTeamFeatures"
              align="right"
              width="60"
            >
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                  >
                    {{ $page.props.auth.user.current_team.name }}
                    <arrow-up-down />
                  </button>
                </span>
              </template>

              <template #content>
                <div class="w-60">
                  <!-- Team Management -->
                  <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Team
                  </div>

                  <!-- Team Settings -->
                  <DropdownLink
                    :href="
                      route('teams.show', $page.props.auth.user.current_team)
                    "
                  >
                    Team Settings
                  </DropdownLink>

                  <DropdownLink
                    v-if="$page.props.jetstream.canCreateTeams"
                    :href="route('teams.create')"
                  >
                    Create New Team
                  </DropdownLink>

                  <!-- Team Switcher -->
                  <template v-if="$page.props.auth.user.all_teams.length > 1">
                    <div
                      class="border-t border-gray-200 dark:border-gray-600"
                    />

                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Switch Teams
                    </div>

                    <template
                      v-for="team in $page.props.auth.user.all_teams"
                      :key="team.id"
                    >
                      <form @submit.prevent="switchToTeam(team)">
                        <DropdownLink as="button">
                          <div class="flex items-center">
                            <GreenTick
                              v-if="
                                team.id == $page.props.auth.user.current_team_id
                              "
                            />
                            <div>{{ team.name }}</div>
                          </div>
                        </DropdownLink>
                      </form>
                    </template>
                  </template>
                </div>
              </template>
            </Dropdown>
          </div>

          <!-- manager dropdown -->
          <div class="ms-3 relative" v-if="$page.props['is-manager']">
            <Dropdown>
              <template #trigger>
                <span
                  role="button"
                  class="text-gray-500 dark:text-gray-400 text-sm"
                  >Manage</span
                >
              </template>

              <template #content>
                <div class="block px-4 py-2 text-xs text-gray-400">Manage</div>

                <DropdownLink :href="route('manager.artists')">
                  Artists
                </DropdownLink>

                <DropdownLink :href="route('manager.categories')">
                  Categories
                </DropdownLink>
                
                <DropdownLink :href="route('manager.tracks')">
                  Tracks
                </DropdownLink>

                <DropdownLink :href="route('manager.users')">
                  Users
                </DropdownLink>
              </template>
            </Dropdown>
          </div>

          <!-- Settings Dropdown -->
          <div class="ms-3 relative">
            <Dropdown align="right" width="48">
              <template #trigger>
                <button
                  v-if="$page.props.jetstream.managesProfilePhotos"
                  class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                >
                  <img
                    class="h-8 w-8 rounded-full object-cover"
                    :src="$page.props.auth.user.profile_photo_url"
                    :alt="$page.props.auth.user.name"
                  />
                </button>

                <span v-else class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                  >
                    {{ $page.props.auth.user.name }}

                    <ArrowDown />
                  </button>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Account
                </div>

                <DropdownLink :href="route('profile.show')">
                  Profile
                </DropdownLink>

                <DropdownLink
                  v-if="$page.props.jetstream.hasApiFeatures"
                  :href="route('api-tokens.index')"
                >
                  API Tokens
                </DropdownLink>

                <div class="border-t border-gray-200 dark:border-gray-600" />

                <!-- Authentication -->
                <form @submit.prevent="logout">
                  <DropdownLink as="button"> Log Out </DropdownLink>
                </form>
              </template>
            </Dropdown>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
          <button
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = !showingNavigationDropdown"
          >
            <OpenClose :open="showingNavigationDropdown" />
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
      :class="{
        block: showingNavigationDropdown,
        hidden: !showingNavigationDropdown,
      }"
      class="sm:hidden transition-all duration-500 ease"
    >
      <div v-if="$page.props.auth.user" class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
          :href="route('dashboard')"
          :active="route().current('dashboard')"
        >
          Dashboard
        </ResponsiveNavLink>

        <ResponsiveNavLink
          :href="route('manager')"
          :active="route().current('manager')"
          v-if="$page.props['is-manager']"
        >
          Manager
        </ResponsiveNavLink>

        <ResponsiveNavLink
          :href="route('admin')"
          :active="route().current('admin')"
          v-if="$page.props['is-admin']"
        >
          Admin
        </ResponsiveNavLink>
      </div>
      <div v-else class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
          :href="route('login')"
          :active="route().current('login')"
        >
          Login
        </ResponsiveNavLink>
        <ResponsiveNavLink
          :href="route('register')"
          :active="route().current('register')"
        >
          Signup
        </ResponsiveNavLink>
      </div>

      <!-- Responsive Settings Options -->
      <div
        class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600"
        v-if="$page.props.auth.user"
      >
        <div class="flex items-center px-4">
          <div
            v-if="$page.props.jetstream.managesProfilePhotos"
            class="shrink-0 me-3"
          >
            <img
              class="h-10 w-10 rounded-full object-cover"
              :src="$page.props.auth.user.profile_photo_url"
              :alt="$page.props.auth.user.name"
            />
          </div>

          <div>
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
              {{ $page.props.auth.user.name }}
            </div>
            <div class="font-medium text-sm text-gray-500">
              {{ $page.props.auth.user.email }}
            </div>
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <ResponsiveNavLink
            :href="route('profile.show')"
            :active="route().current('profile.show')"
          >
            Profile
          </ResponsiveNavLink>

          <ResponsiveNavLink
            v-if="$page.props.jetstream.hasApiFeatures"
            :href="route('api-tokens.index')"
            :active="route().current('api-tokens.index')"
          >
            API Tokens
          </ResponsiveNavLink>

          <!-- Authentication -->
          <form method="POST" @submit.prevent="logout">
            <ResponsiveNavLink as="button"> Log Out </ResponsiveNavLink>
          </form>

          <!-- Team Management -->
          <template v-if="$page.props.jetstream.hasTeamFeatures">
            <div class="border-t border-gray-200 dark:border-gray-600" />

            <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

            <!-- Team Settings -->
            <ResponsiveNavLink
              :href="route('teams.show', $page.props.auth.user.current_team)"
              :active="route().current('teams.show')"
            >
              Team Settings
            </ResponsiveNavLink>

            <ResponsiveNavLink
              v-if="$page.props.jetstream.canCreateTeams"
              :href="route('teams.create')"
              :active="route().current('teams.create')"
            >
              Create New Team
            </ResponsiveNavLink>

            <!-- Team Switcher -->
            <template v-if="$page.props.auth.user.all_teams.length > 1">
              <div class="border-t border-gray-200 dark:border-gray-600" />

              <div class="block px-4 py-2 text-xs text-gray-400">
                Switch Teams
              </div>

              <template
                v-for="team in $page.props.auth.user.all_teams"
                :key="team.id"
              >
                <form @submit.prevent="switchToTeam(team)">
                  <ResponsiveNavLink as="button">
                    <div class="flex items-center">
                      <GreenTick
                        v-if="team.id == $page.props.auth.user.current_team_id"
                      />
                      <div>{{ team.name }}</div>
                    </div>
                  </ResponsiveNavLink>
                </form>
              </template>
            </template>
          </template>
        </div>

        <div class="mt-3 space-y-1" v-if="$page.props['is-manager']">
          <div class="block px-4 py-2 text-sm text-gray-600">Manage</div>
          <ResponsiveNavLink
            :href="route('manager.artists')"
            :active="route().current('manager.artists')"
          >
            Artists
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('manager.categories')"
            :active="route().current('manager.categories')"
          >
            Categories
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('manager.tracks')"
            :active="route().current('manager.tracks')"
          >
            Tracks
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('manager.users')"
            :active="route().current('manager.users')"
          >
            Users
          </ResponsiveNavLink>
        </div>
      </div>
    </div>
  </nav>
</template>
<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import GreenTick from "@/Components/SVG/GreenTick.vue";
import ArrowDown from "@/Components/SVG/ArrowDown.vue";
import ArrowUpDown from "@/Components/SVG/ArrowUpDown.vue";
import OpenClose from "@/Components/SVG/OpenClose.vue";

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
  router.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};

const logout = () => {
  router.post(route("logout"));
};
</script>
