<template>
  <!-- BEGIN SITE CONTAINER -->
  <div class="container-lg d-flex flex-column h-100">

    <!-- BEGIN HEADER -->
    <div class="header">
      <div class="row">
        <div class="col-md-12">
          <a href="/" class="logo"></a>
          <div class="description">personal blog</div>
        </div>
      </div>
    </div>
    <!-- END HEADER -->

    <!-- BEGIN SEARCH -->
    <div class="search">
      <div class="row">
        <div class="col-md-12">
          <SearchBlock/>
        </div>
      </div>
    </div>
    <!-- END SEARCH -->

    <!-- BEGIN CENTER -->
    <div class="main">
      <div class="row">
        <div class="col-md-3">
          <div class="sidebar">
            <CategoryBlock/>
          </div>
        </div>
        <div class="col-md-9">
          <div class="content">
            <router-view></router-view>
          </div>
        </div>
      </div>
    </div>
    <!-- END CENTER -->

    <!-- BEGIN FOOTER -->
    <div class="footer">
      <div class="row">
        <div class="col-md-12">
          <p>© 2021 ascoder.ru - personal blog</p>
        </div>
      </div>
    </div>
    <!-- END FOOTER -->

  </div>
  <!-- END SITE CONTAINER -->
</template>

<script>
import { useUser } from '@/base/use/user'
import SearchBlock from '@/base/layout/front/SearchBlock'
import CategoryBlock from '@/base/layout/front/CategoryBlock'

export default {
  name: 'FrontContainer',
  components: { SearchBlock, CategoryBlock },
  setup () {
    const { fetch, user } = useUser()

    fetch()

    return {
      user
    }
  }
}
</script>

<style lang="scss" scoped>
.header {
  flex: 0 0 auto;
  height: 100px;
  padding: 1rem;
  border-bottom: 1px solid #0071bc;

  .logo {
    display: block;
    width: 292px;
    height: 50px;
    background-image: url('data:image/png;base64,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');
    background-repeat: no-repeat;
  }

  .description {
    color: #535c69;
  }
}

.search {
  padding: 1rem;
  border-bottom: 1px solid #0071bc;
}

.main {
  flex: 1 0 auto;

  .sidebar {
    margin: 1rem;
  }

  .content {
    margin: 1rem;
  }
}

.footer {
  flex: 0 0 auto;
  height: 100px;
  padding: 1rem;
  border-top: 1px solid #0071bc;
}
</style>
