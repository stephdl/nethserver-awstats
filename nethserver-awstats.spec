Summary: nethserver - configure nfs server
%define name nethserver-awstats
Name: %{name}
%define version 0.1.0
%define release 1
Version: %{version}
Release: %{release}%{?dist}
License: GPL
Source: %{name}-%{version}.tar.gz
BuildRoot: /var/tmp/%{name}-%{version}-%{release}-buildroot
Requires: nethserver-virtualhosts
Requires: awstats
Requires: mod_authnz_pam
BuildRequires: nethserver-devtools
BuildArch: noarch

%description
configure awstats for apache analytics

%changelog
* Tue May 09 2017 stephane de Labrusse <stephdl@de-labrusse.fr>
- initial

%prep
%setup

%build
%{makedocs}
perl createlinks

%install
rm -rf $RPM_BUILD_ROOT
(cd root   ; find . -depth -print | cpio -dump $RPM_BUILD_ROOT)
rm -f %{name}-%{version}-%{release}-filelist
%{genfilelist} $RPM_BUILD_ROOT \
  --file /usr/libexec/nethserver/awstatsCronJobs 'attr(0750,root,root)' \
> %{name}-%{version}-%{release}-filelist

%post
%postun

%clean 
rm -rf $RPM_BUILD_ROOT

%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update
%doc COPYING
