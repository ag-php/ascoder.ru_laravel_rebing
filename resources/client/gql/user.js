import gql from 'graphql-tag'

export const CURRENT_USER = gql`
query {
  CurrentUser {
    id
    email
    name
  }
}
`
