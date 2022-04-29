<template>
  <el-radio-group
    v-model="vm"
    :style="attrs.style"
    :class="attrs.className"
    :disabled="attrs.disabled"
    @change="onChange"
  >
    <el-radio-button
      v-if="radio.isButton"
      v-for="(radio, index) in attrs.options"
      :style="radio.style"
      :class="radio.className"
      :key="index"
      :label="radio.label"
      :disabled="radio.disabled"
      :border="radio.border"
      :size="radio.size"
    >
      {{ radio.title }}
    </el-radio-button>
    <el-radio
      v-if="!radio.isButton"
      v-for="(radio, index) in attrs.options"
      :style="radio.style"
      :class="radio.className"
      :key="index"
      :label="radio.label"
      :disabled="radio.disabled"
      :border="radio.border"
      :size="radio.size"
    >
      {{ radio.title }}
    </el-radio>
  </el-radio-group>
</template>
<script>
import { FormItemComponent } from "@/mixins.js";
export default {
  mixins: [FormItemComponent],
  data () {
    return {
      vm: this._.clone(this.value)
    };
  },
  watch: {
    value (value) {
      this.vm = value;
    }
  }
};
</script>
