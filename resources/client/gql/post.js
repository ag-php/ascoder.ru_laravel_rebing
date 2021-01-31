import gql from 'graphql-tag'

export const POST = gql`
query ($slug: String!){
  Post (slug: $slug) {
    id
    slug
    name
    text
    image
    description
    created_at
    updated_at
    active
    categoryId
    category {
      name
    }
  }
}
`

export const POST_LIST = gql`
query ($page: Int!, $size: Int!, $category: String){
  PostList (page: $page, size: $size, category: $category) {
    total
    data {
      id
      slug
      name
      image
      description
      created_at
      updated_at
      active
      categoryId
      category {
        slug
        name
      }
    }
  }
}
`

export const POST_PUSH = gql`
mutation ($slug: String!, $name: String!, $text: String!, $description: String!, $active: Boolean!, $categoryId: Int!){
  PostPush (slug: $slug, name: $name, text: $text, description: $description, active: $active, categoryId: $categoryId) {
    id
    slug
    name
    created_at
    updated_at
    active
  }
}
`

export const POST_DELETE = gql`
mutation ($id: ID!){
  PostDelete (id: $id) {
    success
  }
}
`
