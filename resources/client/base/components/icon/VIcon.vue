<template>
  <svg
      v-if="!src && !use"
      xmlns="http://www.w3.org/2000/svg"
      :viewBox="viewBox"
      :class="computedClasses"
      v-html="titleCode + iconCode"
      role="img"
  ></svg>
  <img
      v-else-if="src"
      :src="src"
      role="img"
  />
  <svg
      v-else-if="use"
      xmlns="http://www.w3.org/2000/svg"
      :class="computedClasses"
      role="img"
  >
    <use :href="use"></use>
  </svg>
</template>

<script>
import { computed } from 'vue'
import icons from './icons'

export default {
  name: 'VIcon',
  props: {
    name: String,
    content: [String, Array],
    size: {
      type: String,
      validator: size => [
        'sm', 'lg', 'xl'
      ].includes(size)
    },
    customClasses: [String, Array, Object],
    src: String,
    title: String,
    use: String
  },
  setup (props, { attrs }) {
    function toCamelCase (str) {
      return str.replace(/([-_][a-z0-9])/ig, ($1) => {
        return $1.toUpperCase()
      }).replace(/-/ig, '')
    }

    const titleCode = computed(() => props.title ? `<title>${props.title}</title>` : '')
    const code = computed(() => icons[toCamelCase(props.name)])
    const iconCode = computed(() => Array.isArray(code.value) ? code.value[1] || code.value[0] : code.value)
    const scale = computed(() => Array.isArray(code.value) && code.value.length > 1 ? code.value.[0] : '64 64')
    const viewBox = computed(() => attrs.viewBox || `0 0 ${scale.value}`)
    const computedClasses = computed(() => props.customClasses || ['icon', { [`icon-${props.size}`]: props.size }])

    return {
      titleCode,
      iconCode,
      viewBox,
      computedClasses
    }
  }
}
</script>
