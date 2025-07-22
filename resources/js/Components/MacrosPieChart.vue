<template>
  <div class="p-4">
    <div class="h-48 flex items-center justify-center">
      <div class="flex flex-col items-center">
        <svg width="200" height="200" viewBox="0 0 200 200">
          <g>
            <template v-for="(macro, i) in macros" :key="macro.name">
              <path
                :d="describeArc(100, 100, 90, 
                  macros.slice(0, i).reduce((a, m) => a + (m.value / total) * 360, 0), 
                  macros.slice(0, i + 1).reduce((a, m) => a + (m.value / total) * 360, 0)
                )"
                :fill="macro.color"
                stroke="#fff"
                stroke-width="2"
              />
            </template>
          </g>
        </svg>
        <div class="mt-4 flex flex-col gap-2">
          <div v-for="macro in macros" :key="macro.name" class="flex items-center gap-2">
            <span :style="{ backgroundColor: macro.color }" class="inline-block w-4 h-4 rounded-full"></span>
            <span class="font-medium">{{ macro.name }}:</span>
            <span>{{ macro.value }}g ({{ ((macro.value / total) * 100).toFixed(0) }}%)</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Example macronutrient data (replace with props or API data as needed)
const macros = [
  { name: 'Protein', value: 30, color: '#4F46E5' },
  { name: 'Carbs', value: 50, color: '#22D3EE' },
  { name: 'Fat', value: 20, color: '#F59E42' }
]

// Calculate total for percentage
const total = macros.reduce((sum, m) => sum + m.value, 0)

// Pie chart arc calculation
function describeArc(cx, cy, r, startAngle, endAngle) {
  const start = polarToCartesian(cx, cy, r, endAngle)
  const end = polarToCartesian(cx, cy, r, startAngle)
  const largeArcFlag = endAngle - startAngle <= 180 ? '0' : '1'
  return [
    'M', start.x, start.y,
    'A', r, r, 0, largeArcFlag, 0, end.x, end.y,
    'L', cx, cy,
    'Z'
  ].join(' ')
}

function polarToCartesian(cx, cy, r, angleInDegrees) {
  const angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0
  return {
    x: cx + r * Math.cos(angleInRadians),
    y: cy + r * Math.sin(angleInRadians)
  }
}
</script>

<style scoped>
/* Add any additional styles here */
</style>
