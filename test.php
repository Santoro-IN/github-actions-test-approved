name: CI + CD

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]
  workflow_dispatch:

jobs:
  Build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2

      - name: Compile
        run: echo Hello, world!
    
  DeployDev:
    name: Deploy to Dev 
    if: github.event_name == 'pull_request'
    needs: [Build]
    runs-on: ubuntu-latest
    environment: 
      name: dev
      url: 'http://dev.myapp.com'
    steps:
      - name: Deploy
        run: echo I am deploying! 
    
  DeployStaging:
    name: Deploy to Staging 
    if: github.event.ref == 'refs/heads/main'
    needs: [Build]
    runs-on: ubuntu-latest
    environment: 
      name: stg
      url: 'http://test.myapp.com'
    steps:
      - name: Deploy
        run: echo I am deploying! 
            
  DeployProd:
    name: Deploy to Production 
    needs: [DeployStaging]
    runs-on: ubuntu-latest
    environment: 
      name: prod
      url: 'http://www.myapp.com'
    steps:
      - name: Deploy
        run: echo I am deploying! 

