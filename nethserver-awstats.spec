Summary: nethserver - configure nfs server
%define name nethserver-awstats
Name: %{name}
%define version 0.1.10
%define release 1
Version: %{version}
Release: %{release}%{?dist}
License: GPL
Source: %{name}-%{version}.tar.gz
BuildRoot: /var/tmp/%{name}-%{version}-%{release}-buildroot
Requires: nethserver-virtualhosts
Requires: awstats
Requires: mod_authnz_pam
Requires: htmldoc
BuildRequires: nethserver-devtools
BuildArch: noarch

%description
configure awstats for apache analytics

%changelog
* Sat Nov 10 2018 stephane de labrusse <stephdl@de-labrusse.fr> 0.1.10.ns7
- Awstats can make pdf report and export to root by email

* Fri Nov 9 2018 stephane de labrusse <stephdl@de-labrusse.fr> 0.1.9.ns7
- Revert geoipv6
- templatize SystemName.DomainName awstats conf

* Fri Nov 9 2018 stephane de labrusse <stephdl@de-labrusse.fr> 0.1.8.ns7
- Enable Email statistics and geoipv6

* Wed Nov 7 2018 stephane de labrusse <stephdl@de-labrusse.fr> 0.1.7.ns7
- Display the manual configuration in the statistics tab

* Sun Nov 4 2018 stephane de Labrusse <stephdl@de-labrusse.fr> 0.1.6.ns7 
- URL and table to browse the default virtualhost statistics

* Sun Nov 12 2017 stephane de Labrusse <stephdl@de-labrusse.fr> 0.1.5.ns7
- translation of the user error message

* Wed Jun 21 2017 stephane de Labrusse <stephdl@de-labrusse.fr> 0.1.4.ns7
- elementList added in template
- ip6 plugin activated
- DnsLookup & GeoIP available option in the panel

* Thu Jun 08 2017 stephane de Labrusse <stephdl@de-labrusse.fr> 0.1.3.ns7
- First release to NS7

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
  --file /etc/cron.weekly/awstatsMakePDFReport 'attr(0750,root,root)' \
> %{name}-%{version}-%{release}-filelist

%post
%postun

%clean 
rm -rf $RPM_BUILD_ROOT

%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update
%doc COPYING
