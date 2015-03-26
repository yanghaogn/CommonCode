package org.apache.hadoop.yarn.client.api.impl;

import org.codehaus.jackson.annotate.JsonIgnoreProperties;

import java.util.LinkedList;
import java.util.List;

/**
 * Created by yang on 14-12-10.
 */
@JsonIgnoreProperties(ignoreUnknown = true)
public class AllJobs {

  private Jobs jobs = new Jobs();

  public Jobs getJobs() {
    return jobs;
  }

  public void setJobs(Jobs jobs) {
    this.jobs = jobs;
  }
  public static class Jobs{
    private List<Job> job = new LinkedList<Job>();

    public List<Job> getJob() {
      return job;
    }

    public void setJob(List<Job> jobs) {
      this.job = jobs;
    }
  }

  public static class Job {
    private int runningReduceAttempts;
    private int reduceProgress;
    private int failedReduceAttempts;
    private int newMapAttempts;
    private int mapsRunning;
    private String state;
    private int successfulReduceAttempts;
    private int reducesRunning;
    private int reducesPending;
    private String user;
    private int reducesTotal;
    private int mapsCompleted;
    private long startTime;
    private String id;
    private int successfulMapAttempts;
    private int runningMapAttempts;
    private int newReduceAttempts;
    private String name;
    private int mapsPending;
    private long elapsedTime;
    private int reducesCompleted;
    private int mapProgress;
    private int diagnostics;
    private int failedMapAttempts;
    private int killedReduceAttempts;
    private int mapsTotal;
    private boolean uberized;
    private int killedMapAttempts;
    private long finishTime;

    public int getRunningReduceAttempts() {
      return runningReduceAttempts;
    }

    public void setRunningReduceAttempts(int runningReduceAttempts) {
      this.runningReduceAttempts = runningReduceAttempts;
    }

    public int getReduceProgress() {
      return reduceProgress;
    }

    public void setReduceProgress(int reduceProgress) {
      this.reduceProgress = reduceProgress;
    }

    public int getFailedReduceAttempts() {
      return failedReduceAttempts;
    }

    public void setFailedReduceAttempts(int failedReduceAttempts) {
      this.failedReduceAttempts = failedReduceAttempts;
    }

    public int getNewMapAttempts() {
      return newMapAttempts;
    }

    public void setNewMapAttempts(int newMapAttempts) {
      this.newMapAttempts = newMapAttempts;
    }

    public int getMapsRunning() {
      return mapsRunning;
    }

    public void setMapsRunning(int mapsRunning) {
      this.mapsRunning = mapsRunning;
    }

    public String getState() {
      return state;
    }

    public void setState(String state) {
      this.state = state;
    }

    public int getSuccessfulReduceAttempts() {
      return successfulReduceAttempts;
    }

    public void setSuccessfulReduceAttempts(int successfulReduceAttempts) {
      this.successfulReduceAttempts = successfulReduceAttempts;
    }

    public int getReducesRunning() {
      return reducesRunning;
    }

    public void setReducesRunning(int reducesRunning) {
      this.reducesRunning = reducesRunning;
    }

    public int getReducesPending() {
      return reducesPending;
    }

    public void setReducesPending(int reducesPending) {
      this.reducesPending = reducesPending;
    }

    public String getUser() {
      return user;
    }

    public void setUser(String user) {
      this.user = user;
    }

    public int getReducesTotal() {
      return reducesTotal;
    }

    public void setReducesTotal(int reducesTotal) {
      this.reducesTotal = reducesTotal;
    }

    public int getMapsCompleted() {
      return mapsCompleted;
    }

    public void setMapsCompleted(int mapsCompleted) {
      this.mapsCompleted = mapsCompleted;
    }

    public long getStartTime() {
      return startTime;
    }

    public void setStartTime(long startTime) {
      this.startTime = startTime;
    }

    public String getId() {
      return id;
    }

    public void setId(String id) {
      this.id = id;
    }

    public int getSuccessfulMapAttempts() {
      return successfulMapAttempts;
    }

    public void setSuccessfulMapAttempts(int successfulMapAttempts) {
      this.successfulMapAttempts = successfulMapAttempts;
    }

    public int getRunningMapAttempts() {
      return runningMapAttempts;
    }

    public void setRunningMapAttempts(int runningMapAttempts) {
      this.runningMapAttempts = runningMapAttempts;
    }

    public int getNewReduceAttempts() {
      return newReduceAttempts;
    }

    public void setNewReduceAttempts(int newReduceAttempts) {
      this.newReduceAttempts = newReduceAttempts;
    }

    public String getName() {
      return name;
    }

    public void setName(String name) {
      this.name = name;
    }

    public int getMapsPending() {
      return mapsPending;
    }

    public void setMapsPending(int mapsPending) {
      this.mapsPending = mapsPending;
    }

    public long getElapsedTime() {
      return elapsedTime;
    }

    public void setElapsedTime(long elapsedTime) {
      this.elapsedTime = elapsedTime;
    }

    public int getReducesCompleted() {
      return reducesCompleted;
    }

    public void setReducesCompleted(int reducesCompleted) {
      this.reducesCompleted = reducesCompleted;
    }

    public int getMapProgress() {
      return mapProgress;
    }

    public void setMapProgress(int mapProgress) {
      this.mapProgress = mapProgress;
    }

    public int getDiagnostics() {
      return diagnostics;
    }

    public void setDiagnostics(int diagnostics) {
      this.diagnostics = diagnostics;
    }

    public int getFailedMapAttempts() {
      return failedMapAttempts;
    }

    public void setFailedMapAttempts(int failedMapAttempts) {
      this.failedMapAttempts = failedMapAttempts;
    }

    public int getKilledReduceAttempts() {
      return killedReduceAttempts;
    }

    public void setKilledReduceAttempts(int killedReduceAttempts) {
      this.killedReduceAttempts = killedReduceAttempts;
    }

    public int getMapsTotal() {
      return mapsTotal;
    }

    public void setMapsTotal(int mapsTotal) {
      this.mapsTotal = mapsTotal;
    }

    public boolean isUberized() {
      return uberized;
    }

    public void setUberized(boolean uberized) {
      this.uberized = uberized;
    }

    public int getKilledMapAttempts() {
      return killedMapAttempts;
    }

    public void setKilledMapAttempts(int killedMapAttempts) {
      this.killedMapAttempts = killedMapAttempts;
    }

    public long getFinishTime() {
      return finishTime;
    }

    public void setFinishTime(long finishTime) {
      this.finishTime = finishTime;
    }
  }
}
