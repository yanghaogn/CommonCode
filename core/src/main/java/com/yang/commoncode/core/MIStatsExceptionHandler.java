
package com.xiaomi.mistatistic.sdk;

import android.annotation.SuppressLint;
import android.content.Context;
import android.os.Build;
import android.os.StrictMode;
import com.xiaomi.mistatistic.sdk.controller.ApplicationContextHolder;
import com.xiaomi.mistatistic.sdk.controller.DeviceIDHolder;
import com.xiaomi.mistatistic.sdk.controller.Logger;
import com.xiaomi.mistatistic.sdk.controller.NetworkUtils;
import com.xiaomi.mistatistic.sdk.controller.PrefPersistUtils;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.PrintWriter;
import java.io.StringWriter;
import java.io.Writer;
import java.lang.Thread.UncaughtExceptionHandler;
import java.util.ArrayList;
import java.util.Map;
import java.util.TreeMap;

public class MIStatsExceptionHandler implements UncaughtExceptionHandler {

	private static final String EXCEPTION_FILE_NAME = ".exceptiondetail";
	private static boolean initialized = false;
	private static final int MAX_EXCEPTION_CNT = 5;

	public static final String EXCEPTION_URL = "https://data.mistat.xiaomi.com/micrash";

	private static final String EXCEPTION_URL_TEST = "http://10.99.168.145:8097/micrash";

	public static final int UPLOAD_NO = 1; // 不上传
	public static final int UPLOAD_NOW = 2; // 立即上传
	public static final int UPLOAD_STATS = 3; // 和统计数据一起上传。
	private static int uploadPolicy = UPLOAD_NO;

	/**
	 * 为当前的context设置exception handler.
	 *
	 * @param context
	 *            当前的context，
	 * @param replace
	 *            是否替换以前的exception handler.
	 */
	public static void registerExceptionHandler(boolean replace) {
		UncaughtExceptionHandler originalHandler = Thread.getDefaultUncaughtExceptionHandler();

		if (originalHandler instanceof MIStatsExceptionHandler) {
			// twice.
			return;
		}

		UncaughtExceptionHandler handler = new MIStatsExceptionHandler(replace ? null : originalHandler);

		Thread.setDefaultUncaughtExceptionHandler(handler);
		initialized = true;
	}

	public static void uploadException(ThrowableDetail exDetail, boolean isManually) {
		new Logger().v("uploadException...");
		if (!initialized)
			return;

		if (exDetail == null || exDetail.throwable == null)
			throw new IllegalArgumentException("the throwable is null.");

		// if there is no useful callstack, just return.
		if (exDetail.throwable.getStackTrace() == null || exDetail.throwable.getStackTrace().length == 0)
			return;

		final Writer result = new StringWriter();
		final PrintWriter printWriter = new PrintWriter(result);
		exDetail.throwable.printStackTrace(printWriter);

		String callstack = result.toString();
		new Logger().d("exception callstack:" + callstack);
		// 发送crash-log url
		Map<String, String> parameters = new TreeMap<String, String>();
		parameters.put("app_id", ApplicationContextHolder.getAppID());
		parameters.put("app_key", ApplicationContextHolder.getAppKey());
		parameters.put("device_uuid", DeviceIDHolder.getDeviceId(ApplicationContextHolder.getApplicationContext()));
		parameters.put("device_os", "Android " + Build.VERSION.SDK_INT);
		parameters.put("device_model", Build.MODEL);
		parameters.put("app_version", exDetail.appVersion);
		parameters.put("app_channel", exDetail.appChannel);
		parameters.put("app_start_time", exDetail.appStartTime);
		parameters.put("app_crash_time", exDetail.appCrashTime);
		parameters.put("crash_exception_type",
				exDetail.throwable.getClass().getName() + ":" + exDetail.throwable.getMessage());
		parameters.put("crash_exception_desc",
				exDetail.throwable instanceof OutOfMemoryError ? "OutOfMemoryError" : callstack);
		parameters.put("crash_callstack", callstack);
		if (isManually) {
			parameters.put("manual", "true");
		}

		try {
			String ret = NetworkUtils.doUpload(ApplicationContextHolder.getApplicationContext(),
					BuildSetting.isTest() ? EXCEPTION_URL_TEST : EXCEPTION_URL, parameters);
			new Logger().v("upload the exception: " + ret);
		} catch (IOException e) {
			new Logger().e("Error to upload the exception ", e);
		}

	}

	public static class ThrowableDetail {
		public Throwable throwable;
		public String appVersion;
		public String appChannel;
		public String appStartTime;
		public String appCrashTime;

		public ThrowableDetail(Throwable ex) {
			throwable = ex;
			appVersion = ApplicationContextHolder.getVersion();
			appChannel = ApplicationContextHolder.getChannel();
			appStartTime = ApplicationContextHolder.getAppStartTime();
			appCrashTime = String.valueOf(System.currentTimeMillis());
		}

		public ThrowableDetail() {
			throwable = null;
			appVersion = ApplicationContextHolder.getVersion();
			appChannel = ApplicationContextHolder.getChannel();
			appStartTime = ApplicationContextHolder.getAppStartTime();
			appCrashTime = null;
		}
	}

	private final UncaughtExceptionHandler mDefaultHandler;

	public MIStatsExceptionHandler() {
		mDefaultHandler = null;
	}

	public MIStatsExceptionHandler(UncaughtExceptionHandler handler) {
		mDefaultHandler = handler;
	}

	@SuppressLint("NewApi")
	@Override
	public void uncaughtException(final Thread thread, final Throwable t) {
		new Logger().v("uncaughtException...");
		if (Build.VERSION.SDK_INT >= 9) {
			StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().build());
		}
		if (MiStatInterface.shouldExceptionUploadImmediately()) {
			// 实时上传，避免反复上传。某些场景下，用户程序会不停崩溃，不要因此而不停发送。
			// 5分钟内，不要超过10次。
			if (!isCrashCrazy()) {
				MIStatsExceptionHandler.uploadException(new ThrowableDetail(t), false);
			} else {
				new Logger().v("crazy crash...");
			}
		} else {
			// record the exception for later upload.
			saveException(t);
		}
		if (mDefaultHandler != null) {
			mDefaultHandler.uncaughtException(thread, t);
		}
	}

	public void uncaughtExceptionManually(final Thread thread, final Throwable t) {
		new Logger().v("uncaughtExceptionManually...");
		if (Build.VERSION.SDK_INT >= 9) {
			StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().build());
		}
		if (MiStatInterface.shouldExceptionUploadImmediately()) {
			// 实时上传，避免反复上传。某些场景下，用户程序会不停崩溃，不要因此而不停发送。
			// 5分钟内，不要超过10次。
			if (!isCrashCrazy()) {
				MIStatsExceptionHandler.uploadException(new ThrowableDetail(t), true);
			} else {
				new Logger().v("crazy crash...");
			}
		} else {
			// record the exception for later upload.
			saveException(t);
		}
		if (mDefaultHandler != null) {
			mDefaultHandler.uncaughtException(thread, t);
		}
	}

	private static final String CRASH_TIME_KEY = "crash_time";

	private static final String CRASH_COUNT_KEY = "crash_count";

	public boolean isCrashCrazy() {
		// 当前崩溃了一次，app是否在不停崩溃。
		long lastTs = PrefPersistUtils.getLong(ApplicationContextHolder.getApplicationContext(), CRASH_TIME_KEY, 0);
		if (System.currentTimeMillis() - lastTs > 5 * 60 * 1000) {
			// 5 分钟前崩溃，重新计数
			PrefPersistUtils.putInt(ApplicationContextHolder.getApplicationContext(), CRASH_COUNT_KEY, 1);
			PrefPersistUtils.putLong(ApplicationContextHolder.getApplicationContext(), CRASH_TIME_KEY,
					System.currentTimeMillis());
		} else {
			// 5 分钟内崩溃，增加计数
			int cnt = PrefPersistUtils.getInt(ApplicationContextHolder.getApplicationContext(), CRASH_COUNT_KEY, 0);

			if (cnt == 0) {
				PrefPersistUtils.putLong(ApplicationContextHolder.getApplicationContext(), CRASH_TIME_KEY,
						System.currentTimeMillis());
			}
			cnt++;
			PrefPersistUtils.putInt(ApplicationContextHolder.getApplicationContext(), CRASH_COUNT_KEY, cnt);
			if (cnt > 10) {
				return true;
			}
		}
		return false;
	}

	public static void saveException(Throwable t) {
		ArrayList<ThrowableDetail> excepts = loadException();
		excepts.add(new ThrowableDetail(t));

		if (excepts.size() > MAX_EXCEPTION_CNT) {
			excepts.remove(0);
		}
		ObjectOutputStream oos = null;
		try {
			FileOutputStream fos = ApplicationContextHolder.getApplicationContext().openFileOutput(EXCEPTION_FILE_NAME,
					Context.MODE_PRIVATE);
			oos = new ObjectOutputStream(fos);
			oos.writeObject(excepts);
		} catch (IOException e) {
			new Logger().e("", e);
		} finally {
			if (oos != null) {
				try {
					oos.close();
				} catch (IOException e) {
					//
				}
			}
		}
	}

	// @SuppressWarnings("unchecked")
	public static ArrayList<ThrowableDetail> loadException() {
		ArrayList<ThrowableDetail> throwables = new ArrayList<ThrowableDetail>();
		ObjectInputStream ois = null;
		boolean exception = false;
		try {
			File dir = ApplicationContextHolder.getApplicationContext().getFilesDir();
			if (dir != null) {
				File exceptionFile = new File(dir, EXCEPTION_FILE_NAME);
				if (exceptionFile.isFile()) {
					ois = new ObjectInputStream(new FileInputStream(exceptionFile));
					throwables = (ArrayList<ThrowableDetail>) ois.readObject();
				}
			}
		} catch (Exception e) {
			new Logger().e("", e);
			exception = true;
		} finally {
			if (ois != null) {
				try {
					ois.close();
				} catch (IOException e) {
					//
				}
			}
		}
		if (exception) {
			// failed to read the exceptions, remove all the exceptions.
			clearException();
		}
		return throwables;
	}

	public static void clearException() {
		File exceptionFile = new File(ApplicationContextHolder.getApplicationContext().getFilesDir(),
				EXCEPTION_FILE_NAME);
		exceptionFile.delete();
	}

	public static void setUploadPolicy(int policy) {
		uploadPolicy = policy;
	}

	public static int getUploadPolicy() {
		return uploadPolicy;
	}
}
