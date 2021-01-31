import gql from 'graphql-tag'

export const CATEGORY = gql`
query ($slug: String!){
  Category (slug: $slug) {
    id
    slug
    name
    created_at
    updated_at
    active
  }
}
`

export const CATEGORY_LIST = gql`
query ($page: Int!, $size: Int!){
  CategoryList (page: $page, size: $size) {
    total
    data {
      id
      slug
      name
      created_at
      updated_at
      active
    }
  }
}
`

export const CATEGORY_PUSH = gql`
mutation ($slug: String!, $name: String!, $active: Boolean!){
  CategoryPush (slug: $slug, name: $name, active: $active) {
    id
    slug
    name
    created_at
    updated_at
    active
  }
}
`

export const CATEGORY_DELETE = gql`
mutation ($id: ID!){
  CategoryDelete (id: $id) {
    success
  }
}
`
