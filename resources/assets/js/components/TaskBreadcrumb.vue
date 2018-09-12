<template>
    <span>
        <task-breadcrumb v-if="item && item.parent" :item="item.parent"></task-breadcrumb>
        <v-icon v-if="item" small>chevron_right</v-icon>
        <router-link v-if="item" :to="`/tasks/${item.id}/manage`">{{item.name}}</router-link>
        <v-icon small v-if="original">chevron_right</v-icon>
        <span v-if="original">{{original.name}}</span>
    </span>
</template>

<script>
export default {
  props: ["item", "original"]
};
</script>

