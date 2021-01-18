export const GQL_USER_ID = 'gql-user-id'
export const GQL_USER_EMAIL = 'gql-user-email'
export const GQL_AUTH_TOKEN = 'gql-auth-token'

export const BASE_URI = process.env.NODE_ENV === 'production'
  ? 'http://ascoder.ru'
  : 'http://127.0.0.1:8000'
