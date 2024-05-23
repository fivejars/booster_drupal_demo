import groovy.json.*

pipeline {
  agent {
    node {
      label 'slave'
      customWorkspace 'builds/booster_drupal_demo/booster_drupal_demo-' + env.BRANCH_NAME
    }
  }
  environment {
    VIRTUAL_HOST = "${BRANCH_NAME.toLowerCase()}.demo.booster.drupal.${VIRTUAL_HOST_BASE}"
    BUILD_URL = "http://${VIRTUAL_HOST}/"
    COMMENT_URL = "https://api.github.com/repos/fivejars/booster_drupal_demo/issues/${CHANGE_ID}/comments"
    SKIP_DB_DATA_VOLUME_UPDATE = 1
    DB_DATA_VOLUME = "/home/jslave/dumps/booster_drupal_demo/latest.sql.gz"
  }
  stages {
    stage('pre-build') {
      steps {
        sh 'fin p rm -f || true'
        sh 'fin up'
      }
    }
    stage('Composer Validate') {
      parallel {
        stage('Composer Validate') {
          steps {
            sh 'fin composer validate'
          }
        }
        stage('Composer Audit') {
          steps {
            catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
              sh 'fin composer audit --locked'
            }
          }
        }
      }
    }
    stage('build') {
      steps {
        sh 'fin init'
      }
    }
    stage('Storybook') {
      steps {
        catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
          sh 'fin storybook'
          echo "Storybook available at ${BUILD_URL}storybook/"
        }
      }
    }
  }
  post {
    success {
      script {
        def body = """\
Successfully built!
--------------

| Environment   | Link          |
| ------------- | ------------- |
| Build         | ${BUILD_URL}  |

--------------
Refer to this link for build results (access rights to CI server needed):
${RUN_DISPLAY_URL}"""

        def jsonbody = JsonOutput.toJson([body: body])
        def response = httpRequest authentication: 'githubfjbot', httpMode: 'POST', requestBody: jsonbody, responseHandle: 'STRING', url: COMMENT_URL
        if (response.status != 201) {
          error("Failed creating comment: " + response.status)
        }
      }
    }
    failure {
      script {
        def body = """\
Failure!
--------------

Refer to this link for build results (access rights to CI server needed):
${RUN_DISPLAY_URL}"""

        def jsonbody = JsonOutput.toJson([body: body])
        httpRequest authentication: 'githubfjbot', httpMode: 'POST', requestBody: jsonbody, responseHandle: 'STRING', url: COMMENT_URL
      }
    }
  }
}
