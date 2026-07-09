# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.5.0] - 2026-07-09

### Added

- **Automatic re-authentication on `401`.** When a request comes back
  unauthenticated, the client now fetches a fresh token and retries the request
  once before failing. Handles tokens that expire or are revoked out from under
  a cached value.
- **Concurrency-safe token acquisition.** Token fetching is guarded by a
  cross-process cache lock with a double-checked read, so a burst of
  simultaneous requests results in a single call to the token endpoint instead
  of a thundering herd.
- **HTTP status on `FailedRequestException`.** The exception's code is now set
  to the response status (e.g. `404`, `500`), so callers can branch on
  `getCode()`. Transport-level and lock-acquisition failures use `0`.

### Changed

- **The client authenticates lazily.** Authentication now happens on the first
  request that needs a token rather than in the constructor. Constructing a
  `Client` no longer performs any I/O.
- **`ClientParameters` construction is explicit.** It now reads exactly
  `location`, `clientId`, and `clientSecret` instead of mass-assigning arbitrary
  keys, and its constructor is annotated with a precise array shape.

### Fixed

- Guard against a negative cache TTL when a token's `expires_in` is smaller than
  the expiry buffer.
- `request()` no longer returns `null` for an empty response body; it returns an
  empty array, matching its declared return type.

### Notes

- Authentication failures now surface on your first `request()` call rather than
  at `new Client(...)`. Catch auth errors around the first request rather than
  around construction.

[3.5.0]: https://github.com/jauntin/pdf-platform-sdk/releases/tag/v3.5.0
