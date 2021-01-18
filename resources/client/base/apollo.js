import { BatchHttpLink } from 'apollo-link-batch-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
import { ApolloClient } from 'apollo-client'
import { createUploadLink } from 'apollo-upload-client'

import { GQL_AUTH_TOKEN } from './settings'

const token = localStorage.getItem(GQL_AUTH_TOKEN) || null

const httpLink = new BatchHttpLink({
  uri: '/q/secret?',
  headers: {
    Authorization: `Bearer ${token}`,
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
})

export const apolloClient = new ApolloClient({
  link: httpLink,
  cache: new InMemoryCache(),
  shouldBatch: true,
  connectToDevTools: false
})

const httpUploadLink = createUploadLink({
  uri: '/q/secret?',
  headers: {
    Authorization: `Bearer ${token}`
  }
})

export const apolloUploadClient = new ApolloClient({
  link: httpUploadLink,
  cache: new InMemoryCache(),
  shouldBatch: true,
  connectToDevTools: false
})

const httpLinkNoAuth = new BatchHttpLink({
  uri: '/q?',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
})

export const apolloClientNoAuth = new ApolloClient({
  link: httpLinkNoAuth,
  cache: new InMemoryCache(),
  shouldBatch: true,
  connectToDevTools: false
})
