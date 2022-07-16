<script setup>
  import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <header>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <RouterLink class="nav-link active btn-sm" aria-current="page" to="/users">Users</RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link active btn-sm" aria-current="page" to="/talks">Talks</RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link active btn-sm" aria-current="page" to="/invites">Invites</RouterLink>
        </li>
<!--        <li class="nav-item">-->
<!--          <RouterLink to="/about">About</RouterLink>-->
<!--          <a class="nav-link active btn-sm" aria-current="page" href="/talks">Talks</a>-->
<!--        </li>-->
<!--        <li class="nav-item">-->
<!--          <a class="nav-link active btn-sm" aria-current="page" href="/"></a>-->
<!--        </li>-->
<!--        <li class="nav-item dropdown">-->
<!--          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"-->
<!--             aria-expanded="false">...</a>-->
<!--          <ul class="dropdown-menu">-->
<!--            <li><a class="dropdown-item" href="/create-talk">Create talk</a></li>-->
<!--            <li><a class="dropdown-item" href="/invite-tree">Invite tree</a></li>-->
<!--            <li>-->
<!--              <hr class="dropdown-divider">-->
<!--            </li>-->
<!--            <li><a class="dropdown-item" href="/log-out">Log out</a></li>-->
<!--          </ul>-->
<!--        </li>-->
      </ul>
  </header>

  <RouterView />
</template>
