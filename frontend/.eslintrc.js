module.exports = {
  root: true,
  env: {
    node: true
  },
  extends: ['plugin:vue/essential', 'eslint:recommended', 'prettier'],
  plugins: ['pug', 'html', 'prettier'],
  parserOptions: {
    parser: 'babel-eslint'
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'comma-dangle': ['error', 'never'],
    // 'vue/html-indent': [
    //   'error',
    //   2,
    //   {
    //     baseIndent: 1
    //   }
    // ],
    // 'vue/script-indent': [
    //   'warn',
    //   2,
    //   {
    //     baseIndent: 1,
    //   },
    // ],
    'prettier/prettier': ['error']
  },
  overrides: [
    {
      files: [
        '**/__tests__/*.{j,t}s?(x)',
        '**/tests/unit/**/*.spec.{j,t}s?(x)'
      ],
      env: {
        jest: true
      }
    }
  ]
}
