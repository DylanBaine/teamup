<template>
    <span>
        <task-breadcrumb :icon="icon" :icon-size="iconSize" :icon-color="iconColor" v-if="item && item.parent" :item="item.parent"></task-breadcrumb>
        <v-icon :color="iconColor" v-if="item" :size="iconSize">{{icon ? icon : 'chevron_right'}}</v-icon>
        <router-link v-if="item" :to="`/tasks/${item.id}/manage`">{{item.name}}</router-link>
        <v-icon :color="iconColor" :size="iconSize" v-if="original">{{icon ? icon : 'chevron_right'}}</v-icon>
        <span v-if="original" style="font-weight: bold;">{{original.name}}</span>
    </span>
</template>

<script>
export default {
  props: ["item", "original", "iconColor", "icon", "iconSize"]
};
</script>

