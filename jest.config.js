module.exports = {
  preset: '@vue/cli-plugin-unit-jest',
  transform: {
    '^.+\\.vue$': 'vue-jest'
  },
  roots: [
    '<rootDir>/resources/client'
  ],
  modulePaths: [
    '<rootDir>/resources/client'
  ],
  moduleDirectories: [
    'node_modules'
  ],
  moduleNameMapper: {
    '^@/base(.*)$': '<rootDir>/resources/client/base/$1'
  }
}
