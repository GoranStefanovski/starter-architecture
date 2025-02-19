<template>
  <Jumbotron>
    <div class="homepage_wrapper">
    <h2>Simplify Your Leave Management</h2>
    <p>
      LeaveSync is an intuitive leave management system designed to streamline time-off requests, <br> approvals, and tracking—all in one place.
    </p>
    
    <ul>
      <li>✅ Easy leave requests</li>
      <li>✅ Automated holiday & weekend exclusion</li>
      <li>✅ Instant approvals & notifications</li>
    </ul>

    <a
      href="https://docs.google.com/document/d/1onPg8l5NdO5NSReJKt0qOC0gyHgefN-IPg943Wo2eEw/edit?usp=sharing"
      target="_blank"
    >
      Learn more & get started
    </a>
  </div>
  </Jumbotron>
</template>

<style lang="scss">
.homepage_wrapper {
  font-family: 'Poppins', sans-serif, 'bold';
  margin-top: -80px;
  color: black;
  text-align: center;

  & > h2 {
    margin-bottom: 12px;
    font-size: 54px;
  }

  & > p {
    margin-bottom: 40px;
    font-size: 24px;
  }

  & > ul {
    padding-left: 0;
    list-style: none;
    > li {
      font-size: 20px;
    }
  }

  & > a {
    font-size: 16px;
  }
}

</style>